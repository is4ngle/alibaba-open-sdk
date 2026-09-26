<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Retry;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Exception\GatewayException;
use Is4ngle\AlibabaOpen\Retry\RateLimitBackoff;

final class RateLimitBackoffTest extends TestCase
{
    public function testComputeDelay(): void
    {
        $b = new RateLimitBackoff(3, 200, 5000);
        $this->assertSame(200, $b->computeDelayMs(0));
        $this->assertSame(400, $b->computeDelayMs(1));
        $this->assertSame(800, $b->computeDelayMs(2));
        $this->assertSame(1600, $b->computeDelayMs(3));
        $this->assertSame(5000, $b->computeDelayMs(10)); // 上限
    }

    public function testRetriesOnRateLimitAndSucceeds(): void
    {
        $calls = 0;
        $sleeps = [];
        $b = new RateLimitBackoff(3, 200, 5000, function (int $ms) use (&$sleeps) {
            $sleeps[] = $ms;
        });

        $result = $b->execute(function () use (&$calls) {
            $calls++;
            if ($calls < 3) {
                throw new GatewayException('rate limited', 'gw.QosRequestLimit', 200, null, true);
            }
            return 'ok';
        });

        $this->assertSame('ok', $result);
        $this->assertSame(3, $calls);
        $this->assertSame([200, 400], $sleeps);
    }

    public function testThrowsAfterRetriesExhausted(): void
    {
        $calls = 0;
        $b = new RateLimitBackoff(2, 1, 1, function () {});

        $this->expectException(GatewayException::class);
        $b->execute(function () use (&$calls) {
            $calls++;
            throw new GatewayException('rate limited', 'gw.QosRequestLimit', 200, null, true);
        });
        $this->assertSame(3, $calls); // 1 次原始 + 2 次重试
    }

    public function testDoesNotRetryNonRateLimitErrors(): void
    {
        $calls = 0;
        $b = new RateLimitBackoff(3, 1, 1, function () {
            $this->fail('不应 sleep');
        });

        try {
            $b->execute(function () use (&$calls) {
                $calls++;
                throw new GatewayException('other gw error', 'gw.SomeOtherError');
            });
            $this->fail('应抛出异常');
        } catch (GatewayException $e) {
            $this->assertSame('gw.SomeOtherError', $e->getErrorCode());
        }
        $this->assertSame(1, $calls);
    }
}
