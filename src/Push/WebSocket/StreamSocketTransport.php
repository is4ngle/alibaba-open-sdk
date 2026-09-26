<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

use Is4ngle\AlibabaOpen\Exception\PushException;

/**
 * 纯 PHP WebSocket 传输（stream_socket_client + 自实现 RFC6455 握手与帧编解码）。
 *
 * 零额外依赖、跨平台（Windows 开发机可直接用）、支持 ws:// 与 wss://。
 * 阻塞式 IO：receive() 内部用 stream_select 控制超时，交还控制权给 WsClient 状态机。
 *
 * 帧编解码要点（RFC 6455）：
 *  - 客户端 -> 服务端的帧必须掩码（mask bit = 1，4 字节随机掩码 XOR payload）；
 *  - 服务端 -> 客户端的帧不掩码；
 *  - 文本消息 opcode=0x1，可能分片（0x0 continuation）；
 *  - 收到 PING(0x9) 自动回 PONG(0xA)；收到 CLOSE(0x8) 回 CLOSE 并断开。
 */
final class StreamSocketTransport implements WsTransportInterface
{
    /** @var resource|null */
    private $socket = null;

    public function connect(string $url, array $headers = []): void
    {
        $this->close();

        $parts = parse_url($url);
        if ($parts === false || !isset($parts['host'])) {
            throw new PushException('WebSocket URL 无效: ' . $url);
        }
        $scheme = $parts['scheme'] ?? 'ws';
        $secure = strtolower($scheme) === 'wss';
        $host = $parts['host'];
        $port = $parts['port'] ?? ($secure ? 443 : 80);
        $path = ($parts['path'] ?? '/') . (isset($parts['query']) ? '?' . $parts['query'] : '');

        $remote = ($secure ? 'ssl' : 'tcp') . '://' . $host . ':' . $port;
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'SNI_enabled' => true,
            ],
        ]);
        $socket = @stream_socket_client(
            $remote,
            $errno,
            $errstr,
            10.0,
            STREAM_CLIENT_CONNECT,
            $context
        );
        if ($socket === false) {
            throw new PushException("WebSocket 连接失败: {$errstr} ({$errno})");
        }
        stream_set_blocking($socket, true);

        // ---- RFC6455 握手 ----
        $key = base64_encode(random_bytes(16));
        $headerLines = [
            'GET ' . $path . ' HTTP/1.1',
            'Host: ' . $host . ($port === 80 || $port === 443 ? '' : ':' . $port),
            'Upgrade: websocket',
            'Connection: Upgrade',
            'Sec-WebSocket-Key: ' . $key,
            'Sec-WebSocket-Version: 13',
        ];
        foreach ($headers as $name => $value) {
            $headerLines[] = $name . ': ' . $value;
        }
        $request = implode("\r\n", $headerLines) . "\r\n\r\n";
        if (@fwrite($socket, $request) === false) {
            fclose($socket);
            throw new PushException('WebSocket 握手请求发送失败');
        }

        $response = $this->readHttpResponseHeaders($socket);
        if (strpos($response, ' 101 ') === false && strpos($response, ' 101') === false) {
            fclose($socket);
            throw new PushException('WebSocket 握手失败（非 101 响应）: ' . mb_substr($response, 0, 200));
        }

        $this->socket = $socket;
    }

    public function send(string $text): void
    {
        $socket = $this->requireSocket();
        $frame = $this->encodeFrame($text, 0x1);
        if (@fwrite($socket, $frame) === false) {
            throw new PushException('WebSocket 帧发送失败');
        }
    }

    public function receive(float $timeoutSec): ?string
    {
        $socket = $this->socket;
        if ($socket === null || !is_resource($socket)) {
            return null;
        }

        $buffer = '';
        while (true) {
            $frame = $this->readFrame($socket, $timeoutSec);
            if ($frame === null) {
                return null; // 超时或断开
            }
            [$opcode, $payload] = $frame;

            switch ($opcode) {
                case 0x1: // 文本（首帧）
                case 0x2: // 二进制（按文本处理）
                    if ($payload === '') {
                        continue 2; // 空帧忽略
                    }
                    $buffer = $payload;
                    break;
                case 0x0: // continuation
                    $buffer .= $payload;
                    break;
                case 0x9: // PING -> PONG
                    @fwrite($socket, $this->encodeFrame($payload, 0xA));
                    continue 2;
                case 0xA: // PONG 忽略
                    continue 2;
                case 0x8: // CLOSE -> 回 CLOSE 并断开
                    @fwrite($socket, $this->encodeFrame('', 0x8));
                    $this->close();
                    return null;
                default:
                    continue 2;
            }

            // 文本帧 FIN 位已在 readFrame 保证（不支持服务端分片时中间返回）
            return $buffer;
        }
    }

    public function close(): void
    {
        if ($this->socket !== null && is_resource($this->socket)) {
            @fclose($this->socket);
        }
        $this->socket = null;
    }

    public function isConnected(): bool
    {
        return $this->socket !== null && is_resource($this->socket);
    }

    // ------------------------------------------------------------------

    /** @return resource */
    private function requireSocket()
    {
        if ($this->socket === null || !is_resource($this->socket)) {
            throw new PushException('WebSocket 未连接');
        }
        return $this->socket;
    }

    /** @param resource $socket */
    private function readHttpResponseHeaders($socket): string
    {
        $response = '';
        while (strpos($response, "\r\n\r\n") === false) {
            $chunk = @fgets($socket, 1024);
            if ($chunk === false) {
                throw new PushException('WebSocket 握手响应读取失败');
            }
            $response .= $chunk;
            if (strlen($response) > 8192) {
                throw new PushException('WebSocket 握手响应过大');
            }
        }
        return $response;
    }

    /**
     * 读取一个完整帧。
     *
     * @param resource $socket
     * @return array{0: int, 1: string}|null [opcode, payload]；超时或断开返回 null
     */
    private function readFrame($socket, float $timeoutSec): ?array
    {
        $head = $this->readBytes($socket, 2, $timeoutSec);
        if ($head === null) {
            return null;
        }
        $b0 = ord($head[0]);
        $b1 = ord($head[1]);
        $fin = ($b0 & 0x80) !== 0;
        $opcode = $b0 & 0x0f;
        $masked = ($b1 & 0x80) !== 0;
        $length = $b1 & 0x7f;

        if ($length === 126) {
            $ext = $this->readBytes($socket, 2, $timeoutSec);
            if ($ext === null) {
                return null;
            }
            $length = unpack('n', $ext)[1];
        } elseif ($length === 127) {
            $ext = $this->readBytes($socket, 8, $timeoutSec);
            if ($ext === null) {
                return null;
            }
            $length = unpack('J', $ext)[1];
        }

        $maskKey = '';
        if ($masked) {
            $mask = $this->readBytes($socket, 4, $timeoutSec);
            if ($mask === null) {
                return null;
            }
            $maskKey = $mask;
        }

        $payload = '';
        if ($length > 0) {
            // 大帧分块读取，每块重新 select（避免长时间阻塞影响上层 tick）
            $remaining = $length;
            while ($remaining > 0) {
                $chunk = $this->readBytes($socket, (int)min($remaining, 65536), $timeoutSec);
                if ($chunk === null) {
                    return null;
                }
                $payload .= $chunk;
                $remaining -= strlen($chunk);
            }
        }

        if ($masked && $maskKey !== '') {
            $payload = $this->applyMask($payload, $maskKey);
        }

        // 不支持分片的中间帧（FIN=0 的 continuation 之外的场景），简单起见按 opcode 返回
        return [$opcode, $payload];
    }

    /**
     * 精确读取 $len 字节（select 超时控制）。
     *
     * @param resource $socket
     * @return string|null
     */
    private function readBytes($socket, int $len, float $timeoutSec): ?string
    {
        $data = '';
        $deadline = microtime(true) + $timeoutSec;
        while (strlen($data) < $len) {
            $read = [$socket];
            $write = $except = [];
            $remaining = $deadline - microtime(true);
            if ($remaining <= 0) {
                return null;
            }
            $selected = @stream_select($read, $write, $except, (int)floor($remaining), (int)(($remaining - floor($remaining)) * 1000000));
            if ($selected === false) {
                return null;
            }
            if ($selected === 0) {
                return null; // 超时
            }
            $chunk = @fread($socket, $len - strlen($data));
            if ($chunk === false || $chunk === '') {
                $this->close();
                return null; // 连接断开
            }
            $data .= $chunk;
        }
        return $data;
    }

    /** 客户端帧：必须掩码 */
    private function encodeFrame(string $payload, int $opcode): string
    {
        $length = strlen($payload);
        $frame = chr(0x80 | $opcode); // FIN=1

        if ($length < 126) {
            $frame .= chr(0x80 | $length);
        } elseif ($length < 65536) {
            $frame .= chr(0x80 | 126) . pack('n', $length);
        } else {
            $frame .= chr(0x80 | 127) . pack('J', $length);
        }

        $mask = random_bytes(4);
        $frame .= $mask . $this->applyMask($payload, $mask);

        return $frame;
    }

    private function applyMask(string $payload, string $mask): string
    {
        $masked = '';
        $len = strlen($payload);
        for ($i = 0; $i < $len; $i++) {
            $masked .= $payload[$i] ^ $mask[$i % 4];
        }
        return $masked;
    }
}
