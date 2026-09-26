<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Retry;

/**
 * 限流指数退避重试。
 *
 * 仅当执行体抛出的 GatewayException->isRateLimited() === true（gw.QosRequestLimit）时重试；
 * 其他任何异常（含非限流的网关错误）直接向上抛出。
 *
 * delay = min(baseDelayMs * 2^attempt, maxDelayMs)，attempt 从 0 开始。
 * Sleeper 可注入（测试用 no-op 实现记录调用序列而不真实 sleep）。
 */
final class RateLimitBackoff
{
    private int $maxRetries;
    private int $baseDelayMs;
    private int $maxDelayMs;
    /** @var callable|null fn(int $ms): void */
    private $sleeper;

    public function __construct(int $maxRetries = 3, int $baseDelayMs = 200, int $maxDelayMs = 5000, ?callable $sleeper = null)
    {
        $this->maxRetries = max(0, $maxRetries);
        $this->baseDelayMs = $baseDelayMs;
        $this->maxDelayMs = $maxDelayMs;
        $this->sleeper = $sleeper;
    }

    /** 纯函数：第 $attempt 次重试前的退避毫秒数 */
    public function computeDelayMs(int $attempt): int
    {
        $delay = (int)round($this->baseDelayMs * pow(2, $attempt));
        return min($delay, $this->maxDelayMs);
    }

    /**
     * 执行 $fn（fn(): TransportResult），限流时退避重试，耗尽后抛最后一次异常。
     *
     * @param callable $fn fn(): mixed
     * @return mixed
     */
    public function execute(callable $fn)
    {
        $attempt = 0;
        while (true) {
            try {
                return $fn();
            } catch (\Is4ngle\AlibabaOpen\Exception\GatewayException $e) {
                if (!$e->isRateLimited() || $attempt >= $this->maxRetries) {
                    throw $e;
                }
                $delay = $this->computeDelayMs($attempt);
                if ($this->sleeper !== null) {
                    ($this->sleeper)($delay);
                } else {
                    usleep($delay * 1000);
                }
                $attempt++;
            }
        }
    }
}
