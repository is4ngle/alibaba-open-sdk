<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Push;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Push\WebSocket\WsClient;
use Is4ngle\AlibabaOpen\Push\WebSocket\WsMessage;
use Is4ngle\AlibabaOpen\Tests\Support\FakeWsTransport;

/**
 * WsClient 状态机测试：CONNECT → CONNECT_ACK → SERVER_PUSH → CONFIRM → 去重 → 消费失败不回执。
 * 时钟固定为 10.0（既触发首轮重连检查 now-0>=10，又不触发心跳 now-0<30）。
 */
final class WsClientStateMachineTest extends TestCase
{
    private Credentials $credentials;

    protected function setUp(): void
    {
        $this->credentials = new Credentials('mykey', 'secretXYZ', 'tok');
    }

    private function connectAck(): string
    {
        return json_encode(['type' => 'CONNECT_ACK']);
    }

    private function serverPush(string $msgId): string
    {
        return json_encode([
            'type' => 'SERVER_PUSH',
            'id' => $msgId,
            'pubTime' => 1700000000000,
            'content' => '{"orderId":"o1"}',
        ]);
    }

    public function testLoopFullHappyPath(): void
    {
        $transport = new FakeWsTransport();

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public array $ids = [];
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->ids[] = $message->getId();
                $this->client?->stop();
                return true;
            }
        };

        $transport->script = [$this->connectAck(), $this->serverPush('1001')];

        $client = new WsClient(
            $this->credentials,
            $handler,
            $transport,
            null,
            null,
            [],
            fn(): float => 10.0
        );
        $handler->client = $client;
        $client->loop();

        $frames = $transport->sentFrames();

        // 帧 1：CONNECT（loop 首轮重连检查发现"已连接但未 ACK"）
        $this->assertSame('CONNECT', $frames[0]['type']);
        $this->assertSame('mykey', $frames[0]['appKey']);
        $this->assertArrayHasKey('sign', $frames[0]);

        // 帧 2：CONFIRM（handler 返回 true）
        $this->assertSame('CONFIRM', $frames[1]['type']);
        $this->assertSame(1001, $frames[1]['relatedId']);
        $this->assertSame(1700000000000, $frames[1]['relatedMsgTime']);
        $this->assertArrayHasKey('id', $frames[1]);
        $this->assertArrayHasKey('costInIsv', $frames[1]);

        $this->assertSame(['1001'], $handler->ids);
        $this->assertFalse($transport->connected); // loop 退出时关闭连接
    }

    public function testHandlerFalseSendsNoConfirm(): void
    {
        $transport = new FakeWsTransport();

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->client?->stop();
                return false;
            }
        };

        $transport->script = [$this->connectAck(), $this->serverPush('2002')];

        $client = new WsClient($this->credentials, $handler, $transport, null, null, [], fn(): float => 10.0);
        $handler->client = $client;
        $client->loop();

        $frames = $transport->sentFrames();
        $this->assertCount(1, $frames); // 只有 CONNECT，无 CONFIRM
        $this->assertSame('CONNECT', $frames[0]['type']);
    }

    public function testDuplicateMsgIdSkipped(): void
    {
        $transport = new FakeWsTransport();

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public int $calls = 0;
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->calls++;
                if ($this->calls === 1) {
                    return true; // 第一条 confirm
                }
                $this->client?->stop();
                return true;
            }
        };

        // 同一 msgId 推送两次 + 一条不同消息触发 handler 停止 loop（去重跳过不会调用 handler）
        $transport->script = [
            $this->connectAck(),
            $this->serverPush('3003'),
            $this->serverPush('3003'),
            $this->serverPush('3999'),
        ];

        $client = new WsClient($this->credentials, $handler, $transport, null, null, [], fn(): float => 10.0);
        $handler->client = $client;
        $client->loop();

        $this->assertSame(2, $handler->calls); // 第一条 + 第三条（重复的第二条被去重跳过）
        $frames = $transport->sentFrames();
        $this->assertCount(3, $frames); // CONNECT + 2 个 CONFIRM
    }

    public function testReconnectOnDeadTransport(): void
    {
        $transport = new FakeWsTransport();
        $transport->connected = false; // 初始断开

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->client?->stop();
                return true;
            }
        };

        $transport->script = [$this->connectAck(), $this->serverPush('4004')];

        $client = new WsClient($this->credentials, $handler, $transport, null, null, [], fn(): float => 10.0);
        $handler->client = $client;
        $client->loop();

        // 断线 → transport->connect() 被调用 → 重发 CONNECT
        $this->assertSame(1, $transport->connectCalls);
        $this->assertSame('CONNECT', $transport->sentFrames()[0]['type']);
    }

    public function testHeartbeatFiresAfterInterval(): void
    {
        $transport = new FakeWsTransport();

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->client?->stop();
                return true;
            }
        };

        $transport->script = [$this->connectAck(), $this->serverPush('5005')];

        // 时钟 100：心跳条件 now-0>=30 满足（每轮循环都会先发心跳再读消息）
        $client = new WsClient(
            $this->credentials,
            $handler,
            $transport,
            null,
            null,
            ['heartbeat_interval' => 30],
            fn(): float => 100.0
        );
        $handler->client = $client;
        $client->loop();

        $frames = $transport->sentFrames();
        $types = array_column($frames, 'type');
        $this->assertContains('CONNECT', $types);
        $this->assertContains('HEARTBEAT', $types);
        $this->assertContains('CONFIRM', $types);
    }

    public function testSystemMessageDoesNotReachHandler(): void
    {
        $transport = new FakeWsTransport();

        $handler = new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public ?WsClient $client = null;
            public function onMessage(WsMessage $message): bool
            {
                $this->client?->stop();
                return true;
            }
        };

        $transport->script = [
            $this->connectAck(),
            json_encode(['type' => 'SYSTEM', 'content' => 'sys warn']),
            $this->serverPush('6006'),
        ];

        $client = new WsClient($this->credentials, $handler, $transport, null, null, [], fn(): float => 10.0);
        $handler->client = $client;
        $client->loop();

        $frames = $transport->sentFrames();
        // SYSTEM 不产生 CONFIRM，仅一条业务 CONFIRM
        $confirms = array_values(array_filter($frames, fn(array $f) => $f['type'] === 'CONFIRM'));
        $this->assertCount(1, $confirms);
    }

    public function testSendConnectFrameShape(): void
    {
        $transport = new FakeWsTransport();
        $transport->connected = true;
        $client = new WsClient($this->credentials, new class implements \Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface {
            public function onMessage(WsMessage $message): bool
            {
                return true;
            }
        }, $transport, null, null, [], fn(): float => 10.0);

        $client->sendConnect();
        $frame = $transport->sentFrames()[0];

        $this->assertSame('CONNECT', $frame['type']);
        $this->assertSame('mykey', $frame['appKey']);
        $this->assertSame(10000, $frame['pubTime']); // 10.0 * 1000
        // sign = 大写HEX(MD5(secret.appKey.pubTime))
        $expected = strtoupper(bin2hex(md5('secretXYZ' . 'mykey' . '10000', true)));
        $this->assertSame($expected, $frame['sign']);
        // null/空字段不序列化（对齐 fastjson 默认行为）
        $this->assertArrayNotHasKey('content', $frame);
        $this->assertArrayNotHasKey('secret', $frame);
    }
}
