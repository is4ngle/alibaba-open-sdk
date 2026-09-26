<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Exception\PushException;
use Is4ngle\AlibabaOpen\Sign\HeartbeatSigner;

/**
 * WebSocket 推送通道客户端（协议状态机，移植自官方 tuna TunaWebSocketClient）。
 *
 * 协议流程：
 *  1. TCP+RFC6455 握手后发送 CONNECT 帧 {appKey, type:CONNECT, pubTime, sign}，
 *     sign = 大写HEX(MD5(secret.appKey.pubTime))；
 *  2. 收到 CONNECT_ACK 置为已连接；
 *  3. 每 30s 发送 HEARTBEAT 帧（仅已连接时）；
 *  4. 收到 SERVER_PUSH 调用 handler：返回 true → 回 CONFIRM 帧（含 costInIsv 毫秒耗时）；
 *     返回 false / 抛异常 → 不 confirm，平台将择机重发（SDK 按 msgId 去重）；
 *  5. 每 10s 检查：底层连接失效 → 重连并重发 CONNECT；连接在但未收到 ACK → 重发 CONNECT。
 *
 * loop() 为阻塞式事件循环，宿主负责以常驻进程方式运行（如 php think 命令 + supervisor）。
 * 传输层可注入（测试用 FakeWsTransport 驱动状态机）。
 */
final class WsClient
{
    public const DEFAULT_URL = 'ws://message.1688.com/websocket';
    public const HEARTBEAT_INTERVAL = 30; // 秒
    public const RECONNECT_INTERVAL = 10; // 秒
    public const RECEIVE_TICK = 1.0;      // 秒，单次 receive 超时（决定状态机时间精度）

    public const TYPE_CONNECT = 'CONNECT';
    public const TYPE_CONNECT_ACK = 'CONNECT_ACK';
    public const TYPE_HEARTBEAT = 'HEARTBEAT';
    public const TYPE_CONFIRM = 'CONFIRM';
    public const TYPE_SERVER_PUSH = 'SERVER_PUSH';
    public const TYPE_CLOSE = 'CLOSE';
    public const TYPE_SYSTEM = 'SYSTEM';

    private Credentials $credentials;
    private WsHandlerInterface $handler;
    private WsTransportInterface $transport;
    private DedupStoreInterface $dedup;
    private LoggerInterface $logger;
    /** @var callable|null fn(): float 秒级时间戳（测试注入固定时钟） */
    private $clock;

    private string $url;
    private bool $stopped = false;
    /** 是否已收到 CONNECT_ACK（与底层连接有效性区分，对齐 tuna isConnect 语义） */
    private bool $acknowledged = false;

    /**
     * @param array{ws_url?: string, heartbeat_interval?: int, reconnect_interval?: int, receive_tick?: float, max_runtime_sec?: float|null} $config
     */
    public function __construct(
        Credentials $credentials,
        WsHandlerInterface $handler,
        ?WsTransportInterface $transport = null,
        ?DedupStoreInterface $dedup = null,
        ?LoggerInterface $logger = null,
        array $config = [],
        ?callable $clock = null
    ) {
        $this->credentials = $credentials;
        $this->handler = $handler;
        $this->transport = $transport ?? new StreamSocketTransport();
        $this->dedup = $dedup ?? new MemoryDedupStore();
        $this->logger = $logger ?? new NullLogger();
        $this->url = (string)($config['ws_url'] ?? self::DEFAULT_URL);
        $this->heartbeatInterval = (int)($config['heartbeat_interval'] ?? self::HEARTBEAT_INTERVAL);
        $this->reconnectInterval = (int)($config['reconnect_interval'] ?? self::RECONNECT_INTERVAL);
        $this->receiveTick = (float)($config['receive_tick'] ?? self::RECEIVE_TICK);
        $this->maxRuntimeSec = $config['max_runtime_sec'] ?? null;
        $this->clock = $clock ?? static fn(): float => microtime(true);
    }

    private int $heartbeatInterval;
    private float $reconnectInterval;
    private float $receiveTick;
    private ?float $maxRuntimeSec;

    /**
     * 阻塞式事件循环（连接 -> 心跳 -> 收消息 -> confirm -> 断线重连），直到 stop() / 运行时上限 / 致命错误。
     */
    public function loop(): void
    {
        $this->stopped = false;
        $startedAt = ($this->clock)();
        $lastHeartbeat = 0.0;
        $lastReconnectCheck = 0.0;

        while (!$this->stopped) {
            $now = ($this->clock)();

            // 运行时上限（调试观察用；常驻进程不配置）
            if ($this->maxRuntimeSec !== null && $now - $startedAt >= $this->maxRuntimeSec) {
                $this->logger->info('ws: 达到 max_runtime_sec，退出循环');
                break;
            }

            // 周期检查：连接失效重连 / 未 ACK 重发 CONNECT
            if ($now - $lastReconnectCheck >= $this->reconnectInterval) {
                $lastReconnectCheck = $now;
                $this->reconnectIfNeeded();
            }

            // 心跳（仅已连接且已 ACK 时）
            if ($this->acknowledged && $this->transport->isConnected() && $now - $lastHeartbeat >= $this->heartbeatInterval) {
                $lastHeartbeat = $now;
                $this->sendHeartbeat();
            }

            // 读取消息（tick 超时借机回到循环顶部做周期检查）
            $text = $this->transport->receive($this->receiveTick);
            if ($text !== null) {
                $this->handleText($text);
                continue;
            }

            // 连接已断且无消息：立即触发重连检查
            if (!$this->transport->isConnected()) {
                $lastReconnectCheck = 0.0; // 强制下一轮重连
            }
        }

        $this->shutdownTransport();
    }

    public function stop(): void
    {
        $this->stopped = true;
    }

    /** 是否处于正常连接状态（已 ACK 且底层连接有效） */
    public function isConnected(): bool
    {
        return $this->acknowledged && $this->transport->isConnected();
    }

    /** 发送 CONNECT 帧（不抛异常：签名/发送失败记录日志，交由重连机制重试） */
    public function sendConnect(): void
    {
        $pubTime = (int)round(($this->clock)() * 1000);
        $frame = $this->buildFrame(self::TYPE_CONNECT, [
            'appKey' => $this->credentials->getAppKey(),
            'pubTime' => $pubTime,
        ]);
        $frame['sign'] = HeartbeatSigner::sign(
            $this->credentials->getAppKey(),
            $this->credentials->getAppSecret(),
            null,
            $pubTime
        );
        $this->sendJson($frame);
    }

    public function sendHeartbeat(): void
    {
        $pubTime = (int)round(($this->clock)() * 1000);
        $frame = $this->buildFrame(self::TYPE_HEARTBEAT, [
            'appKey' => $this->credentials->getAppKey(),
            'pubTime' => $pubTime,
        ]);
        $frame['sign'] = HeartbeatSigner::sign(
            $this->credentials->getAppKey(),
            $this->credentials->getAppSecret(),
            null,
            $pubTime
        );
        $this->sendJson($frame);
    }

    /** 处理一条文本消息（JSON 帧） */
    public function handleText(string $text): void
    {
        $decoded = json_decode($text, true);
        if (!is_array($decoded)) {
            $this->logger->warning('ws: 非 JSON 帧', ['text' => mb_substr($text, 0, 200)]);
            return;
        }

        $message = new WsMessage($decoded);
        switch ($message->getType()) {
            case self::TYPE_CONNECT_ACK:
                $this->acknowledged = true;
                $this->logger->info('ws: CONNECT_ACK，连接就绪');
                break;

            case self::TYPE_SERVER_PUSH:
                $this->handleServerPush($message);
                break;

            case self::TYPE_SYSTEM:
                $this->logger->warning('ws: SYSTEM 消息', ['content' => $message->getContent()]);
                break;

            case self::TYPE_CLOSE:
                $this->logger->info('ws: 服务端 CLOSE');
                $this->acknowledged = false;
                break;

            default:
                // HEARTBEAT/CONFIRM 回执等其他类型：忽略
                break;
        }
    }

    /** 暴露给测试：确认回执帧构造逻辑 */
    public function confirm(WsMessage $message, int $costInIsvMs): void
    {
        $confirm = $this->buildFrame(self::TYPE_CONFIRM, [
            'id' => $this->uuid(),
            'pubTime' => (int)round(($this->clock)() * 1000),
            'relatedMsgTime' => $message->getPubTime(),
            'relatedId' => $message->getId() !== null ? (int)$message->getId() : null,
            'costInIsv' => $costInIsvMs,
            'msgSource' => $message->getMsgSource(),
        ]);
        $this->sendJson($confirm);
    }

    // ------------------------------------------------------------------

    private function handleServerPush(WsMessage $message): void
    {
        $msgId = $message->getId() ?? '';
        if ($msgId !== '' && !$this->dedup->remember($msgId)) {
            $this->logger->info('ws: 重复消息跳过', ['msgId' => $msgId]);
            return;
        }

        $start = (int)round(($this->clock)() * 1000);
        $ok = false;
        try {
            $ok = $this->handler->onMessage($message);
        } catch (\Throwable $e) {
            $this->logger->error('ws: 业务 handler 异常', ['msgId' => $msgId, 'error' => $e->getMessage()]);
            $ok = false;
        }

        if ($ok) {
            $cost = (int)round(($this->clock)() * 1000) - $start;
            $this->confirm($message, $cost);
            $this->logger->info('ws: 消息已确认', ['msgId' => $msgId, 'costInIsv' => $cost]);
        } else {
            $this->logger->warning('ws: 消息消费失败，不确认（平台将重发）', ['msgId' => $msgId]);
        }
    }

    private function reconnectIfNeeded(): void
    {
        if ($this->stopped) {
            return;
        }
        if (!$this->transport->isConnected()) {
            $this->logger->info('ws: 底层连接失效，重连');
            $this->acknowledged = false;
            try {
                $this->transport->connect($this->url, ['client_version' => '1']);
                $this->sendConnect();
            } catch (PushException $e) {
                $this->logger->error('ws: 重连失败', ['error' => $e->getMessage()]);
            }
            return;
        }
        if (!$this->acknowledged) {
            // 连接在但未收到 ACK（如握手后 CONNECT 丢失）：重发 CONNECT
            $this->logger->info('ws: 已连接但未 ACK，重发 CONNECT');
            $this->sendConnect();
        }
    }

    /**
     * @param array<string, mixed> $fields
     * @return array<string, mixed>
     */
    private function buildFrame(string $type, array $fields): array
    {
        $frame = $fields;
        $frame['type'] = $type;
        // 对齐 fastjson 默认行为：null / 空串字段不序列化
        return array_filter($frame, static fn($v) => $v !== null && $v !== '');
    }

    /** @param array<string, mixed> $frame */
    private function sendJson(array $frame): void
    {
        $json = json_encode($frame, JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            $this->logger->error('ws: 帧编码失败');
            return;
        }
        try {
            $this->transport->send($json);
            $this->logger->debug('ws: 发送帧', ['frame' => $json]);
        } catch (\Throwable $e) {
            $this->logger->error('ws: 发送失败', ['error' => $e->getMessage()]);
        }
    }

    private function shutdownTransport(): void
    {
        $this->acknowledged = false;
        try {
            $this->transport->close();
        } catch (\Throwable $e) {
            $this->logger->warning('ws: 关闭连接异常', ['error' => $e->getMessage()]);
        }
    }

    /** 无横线 UUID（对齐 tuna getUUID） */
    private function uuid(): string
    {
        $s = str_replace('-', '', sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        ));
        return str_replace('-', '', $s);
    }
}
