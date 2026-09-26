<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push;

/**
 * 平台推送的消息内容（HTTP 回调通道与 WebSocket 通道共用契约，对齐官方 tuna MessageContent）。
 *
 * 幂等键：msgId（平台会择机重发，消费方须按 msgId 去重）。
 */
final class PushMessage
{
    private string $msgId;
    private int $gmtBorn;
    /** @var array<string, mixed> */
    private array $data;
    private string $userInfo;
    /** 消息类型，每个业务消息唯一，消费方按此分发 */
    private string $type;
    private ?string $bizKey;
    /** @var array<string, mixed> */
    private array $extraInfo;

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $extraInfo
     */
    public function __construct(
        string $msgId,
        int $gmtBorn,
        array $data,
        string $userInfo,
        string $type,
        ?string $bizKey = null,
        array $extraInfo = []
    ) {
        $this->msgId = $msgId;
        $this->gmtBorn = $gmtBorn;
        $this->data = $data;
        $this->userInfo = $userInfo;
        $this->type = $type;
        $this->bizKey = $bizKey;
        $this->extraInfo = $extraInfo;
    }

    /** 消息 ID，唯一标识（幂等键） */
    public function getMsgId(): string
    {
        return $this->msgId;
    }

    /** 消息产生时间（1970.1.1 起毫秒数） */
    public function getGmtBorn(): int
    {
        return $this->gmtBorn;
    }

    /** @return array<string, mixed> 业务消息数据（JSON） */
    public function getData(): array
    {
        return $this->data;
    }

    /** 推送目标用户 memberId */
    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    /** 消息类型（每个业务消息唯一，分发键） */
    public function getType(): string
    {
        return $this->type;
    }

    /** 业务主键（可选） */
    public function getBizKey(): ?string
    {
        return $this->bizKey;
    }

    /** @return array<string, mixed> 扩展字段（暂未启用） */
    public function getExtraInfo(): array
    {
        return $this->extraInfo;
    }
}
