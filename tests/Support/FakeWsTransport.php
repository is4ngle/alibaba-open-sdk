<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Support;

use Is4ngle\AlibabaOpen\Push\WebSocket\WsTransportInterface;

/**
 * 脚本化 Fake 传输层：receive() 依次弹出 script 中预置的入站帧；sent 记录全部出站帧。
 */
final class FakeWsTransport implements WsTransportInterface
{
    /** @var string[] 出站帧记录 */
    public array $sent = [];
    /** @var string[] 入站帧脚本（receive 依次弹出） */
    public array $script = [];
    public bool $connected = false;
    public int $connectCalls = 0;

    public function connect(string $url, array $headers = []): void
    {
        $this->connectCalls++;
        $this->connected = true;
    }

    public function send(string $text): void
    {
        $this->sent[] = $text;
    }

    public function receive(float $timeoutSec): ?string
    {
        return array_shift($this->script) ?? null;
    }

    public function close(): void
    {
        $this->connected = false;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    /** @return array<string, mixed>[] 解码后的出站帧 */
    public function sentFrames(): array
    {
        return array_map(static fn(string $s): array => json_decode($s, true), $this->sent);
    }
}
