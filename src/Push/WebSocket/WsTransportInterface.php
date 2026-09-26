<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

/**
 * WebSocket 传输抽象：WsClient 状态机只依赖本接口。
 *
 * 实现类：
 *  - StreamSocketTransport：纯 PHP stream_socket_client + 自实现 RFC6455（默认，Windows 可用，支持 wss）
 *  - SwooleCoroutineTransport：Swoole 协程客户端（suggest ext-swoole，生产环境常驻使用）
 */
interface WsTransportInterface
{
    /**
     * 建立连接（含 RFC6455 握手）。已连接时先关闭旧连接。
     *
     * @param array<string, string> $headers 附加 HTTP 握手头
     * @throws \Is4ngle\AlibabaOpen\Exception\PushException 连接失败
     */
    public function connect(string $url, array $headers = []): void;

    /** 发送一个文本帧 */
    public function send(string $text): void;

    /**
     * 读取下一条完整文本消息。
     *
     * @param float $timeoutSec 最长等待秒数；超时返回 null（调用方借机执行心跳/重连检查）
     * @return string|null 文本消息；连接断开返回 null
     */
    public function receive(float $timeoutSec): ?string;

    /** 发送 CLOSE 帧并关闭连接 */
    public function close(): void;

    /** 底层连接是否仍然有效 */
    public function isConnected(): bool;
}
