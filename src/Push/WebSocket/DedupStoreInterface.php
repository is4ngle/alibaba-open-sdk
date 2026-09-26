<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

/**
 * 消息去重存储接口（平台会对未 confirm 的消息择机重发，消费须按 msgId 幂等）。
 */
interface DedupStoreInterface
{
    /**
     * 记录 msgId。
     *
     * @return bool true = 首次出现；false = 已存在（重复消息，应跳过）
     */
    public function remember(string $msgId): bool;
}
