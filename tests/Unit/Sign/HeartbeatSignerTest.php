<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Sign;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Sign\HeartbeatSigner;

/**
 * WS CONNECT/HEARTBEAT 帧签名测试（tuna ClientUtils 契约：MD5(secret.appKey[.content].pubTime) 大写 HEX）。
 */
final class HeartbeatSignerTest extends TestCase
{
    public function testGoldenVectorWithoutContent(): void
    {
        $sign = HeartbeatSigner::sign('mykey', 'secretXYZ', null, 1700000000000);
        $this->assertSame('B9E65D4592778AE92A46050E139FABC6', $sign);
    }

    public function testGoldenVectorWithContent(): void
    {
        $sign = HeartbeatSigner::sign('mykey', 'secretXYZ', 'content-str', 1700000000000);
        $this->assertSame('252610EA907DCC37211639F39097455A', $sign);
    }

    public function testEmptyContentSkipped(): void
    {
        $withEmpty = HeartbeatSigner::sign('mykey', 'secretXYZ', '', 1700000000000);
        $withNull = HeartbeatSigner::sign('mykey', 'secretXYZ', null, 1700000000000);
        $this->assertSame($withNull, $withEmpty);
    }

    public function testUppercaseHex32(): void
    {
        $sign = HeartbeatSigner::sign('k', 's', null, 1);
        $this->assertMatchesRegularExpression('/^[0-9A-F]{32}$/', $sign);
    }
}
