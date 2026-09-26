<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

/**
 * 内存去重存储（FIFO 容量上限，防止常驻进程内存无限增长）。
 * 单进程内存实现：进程重启后去重状态丢失；宿主需要跨进程/持久去重时实现 DedupStoreInterface 注入（如接 Redis）。
 */
final class MemoryDedupStore implements DedupStoreInterface
{
    /** @var array<string, true> */
    private array $seen = [];
    private int $capacity;

    public function __construct(int $capacity = 10000)
    {
        $this->capacity = $capacity;
    }

    public function remember(string $msgId): bool
    {
        if (isset($this->seen[$msgId])) {
            return false;
        }
        if (count($this->seen) >= $this->capacity) {
            // 移除最早插入的条目（array_key_first）
            $oldest = array_key_first($this->seen);
            if ($oldest !== null) {
                unset($this->seen[$oldest]);
            }
        }
        $this->seen[$msgId] = true;
        return true;
    }
}
