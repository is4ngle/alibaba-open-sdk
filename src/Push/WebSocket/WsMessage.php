<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

/**
 * WebSocket 通道消息（对齐官方 tuna WebSocketMessage 契约）。
 *
 * type 取值（WebSocketMessageType）：CONNECT / CONNECT_ACK / HEARTBEAT / CONFIRM / SERVER_PUSH / CLIENT_PUSH / CLOSE / SYSTEM
 * 其中业务上需要关注的主要是 SERVER_PUSH（业务推送）与 SYSTEM（系统错误提示）。
 */
final class WsMessage
{
    /** @var array<string, mixed> 原始解码数组 */
    private array $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
    }

    /** @return array<string, mixed> */
    public function getRaw(): array
    {
        return $this->raw;
    }

    public function getType(): string
    {
        return (string)($this->raw['type'] ?? '');
    }

    /** 消息 id（SERVER_PUSH 时为数值串，CONFIRM 回执时为 UUID） */
    public function getId(): ?string
    {
        $id = $this->raw['id'] ?? null;
        return $id === null ? null : (string)$id;
    }

    /** 消息推送时间（毫秒） */
    public function getPubTime(): ?int
    {
        return isset($this->raw['pubTime']) ? (int)$this->raw['pubTime'] : null;
    }

    /** 消息内容（JSON 串） */
    public function getContent(): ?string
    {
        $content = $this->raw['content'] ?? null;
        return $content === null ? null : (string)$content;
    }

    /** @return array<string, mixed> content 解码后的数组（无法解码时返回空数组） */
    public function getContentArray(): array
    {
        $content = $this->getContent();
        if ($content === null || $content === '') {
            return [];
        }
        $decoded = json_decode($content, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function getAppKey(): ?string
    {
        $appKey = $this->raw['appKey'] ?? null;
        return $appKey === null ? null : (string)$appKey;
    }

    public function getSign(): ?string
    {
        $sign = $this->raw['sign'] ?? null;
        return $sign === null ? null : (string)$sign;
    }

    /** 数据来源：MOCK（测试数据）/ REAL（真实数据，空时默认真实） */
    public function getMsgSource(): ?string
    {
        $msgSource = $this->raw['msgSource'] ?? null;
        return $msgSource === null ? null : (string)$msgSource;
    }

    /** 转为 PushMessage（SERVER_PUSH 业务消息视角） */
    public function toPushMessage(): \Is4ngle\AlibabaOpen\Push\PushMessage
    {
        $content = $this->getContentArray();
        return new \Is4ngle\AlibabaOpen\Push\PushMessage(
            (string)($this->raw['id'] ?? ''),
            (int)($this->raw['pubTime'] ?? 0),
            $content,
            (string)($content['userInfo'] ?? ''),
            (string)($this->raw['type'] ?? ''),
            isset($content['bizKey']) ? (string)$content['bizKey'] : null,
            is_array($content['extraInfo'] ?? null) ? $content['extraInfo'] : []
        );
    }
}
