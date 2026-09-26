<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

use Is4ngle\AlibabaOpen\Exception\PushException;

/**
 * Swoole 协程 WebSocket 传输（生产环境常驻使用，依赖 ext-swoole，本 SDK 仅 suggest 不硬依赖）。
 *
 * 使用方式：宿主在 \Co\run / think-swoole 协程环境内构造并运行 WsClient。
 * 若未安装 ext-swoole，构造时直接抛 PushException（宿主应探测 extension_loaded('swoole') 后选用）。
 */
final class SwooleCoroutineTransport implements WsTransportInterface
{
    /** @var \Swoole\Coroutine\Http\Client|null */
    private $client = null;
    private string $url = '';

    public function __construct()
    {
        if (!class_exists(\Swoole\Coroutine\Http\Client::class)) {
            throw new PushException('ext-swoole 未安装，无法使用 SwooleCoroutineTransport（可改用 StreamSocketTransport）');
        }
    }

    public function connect(string $url, array $headers = []): void
    {
        $this->close();

        $parts = parse_url($url);
        if ($parts === false || !isset($parts['host'])) {
            throw new PushException('WebSocket URL 无效: ' . $url);
        }
        $secure = strtolower($parts['scheme'] ?? 'ws') === 'wss';
        $host = $parts['host'];
        $port = $parts['port'] ?? ($secure ? 443 : 80);
        $path = ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');

        $client = new \Swoole\Coroutine\Http\Client($host, $port, $secure);
        foreach ($headers as $name => $value) {
            $client->setHeaders([$name => $value]);
        }
        $client->set(['timeout' => 10]);

        if (!$client->upgrade($path)) {
            $err = $client->errCode . ' ' . ($client->errMsg ?? '');
            $client->close();
            throw new PushException('WebSocket 握手失败: ' . $err);
        }

        $this->client = $client;
        $this->url = $url;
    }

    public function send(string $text): void
    {
        $client = $this->client;
        if ($client === null) {
            throw new PushException('WebSocket 未连接');
        }
        if (!$client->push($text, WEBSOCKET_OPCODE_TEXT)) {
            throw new PushException('WebSocket 帧发送失败: ' . $client->errCode . ' ' . $client->errMsg);
        }
    }

    public function receive(float $timeoutSec): ?string
    {
        $client = $this->client;
        if ($client === null) {
            return null;
        }
        $frame = $client->recv((float)$timeoutSec);
        if ($frame === false || $frame === '') {
            // recv 超时或出错：连接已断时关闭
            if ($client->errCode !== 0 && $client->errCode !== SOCKET_TIMEOUT) {
                $this->close();
            }
            return null;
        }
        if (is_string($frame)) {
            return $frame;
        }
        // \Swoole\WebSocket\Frame 对象
        if ($frame instanceof \Swoole\WebSocket\Frame) {
            if ($frame->opcode === WEBSOCKET_OPCODE_TEXT || $frame->opcode === WEBSOCKET_OPCODE_PONG) {
                return (string)$frame->data;
            }
            if ($frame->opcode === WEBSOCKET_OPCODE_CLOSE) {
                $this->close();
                return null;
            }
            return null; // ping 等其他帧：swoole 自动处理 ping/pong
        }
        return null;
    }

    public function close(): void
    {
        if ($this->client !== null) {
            $this->client->close();
            $this->client = null;
        }
    }

    public function isConnected(): bool
    {
        return $this->client !== null && $this->client->connected;
    }
}
