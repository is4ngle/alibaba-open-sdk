<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Config;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Exception\InvalidCredentialsException;

final class CredentialsTest extends TestCase
{
    public function testStaticToken(): void
    {
        $c = new Credentials('k', 's', 'tok');
        $this->assertSame('k', $c->getAppKey());
        $this->assertSame('s', $c->getAppSecret());
        $this->assertSame('tok', $c->getAccessToken());
        $this->assertTrue($c->hasAccessToken());
    }

    public function testTokenProviderUsedWhenStaticEmpty(): void
    {
        $c = new Credentials('k', 's', null, fn(): string => 'dynamic-tok');
        $this->assertSame('dynamic-tok', $c->getAccessToken());
    }

    public function testStaticTokenWinsOverProvider(): void
    {
        $c = new Credentials('k', 's', 'static', fn(): string => 'dynamic');
        $this->assertSame('static', $c->getAccessToken());
    }

    public function testThrowsWhenNoTokenAtAll(): void
    {
        $c = new Credentials('k', 's');
        $this->expectException(InvalidCredentialsException::class);
        $c->getAccessToken();
    }

    public function testWithAccessToken(): void
    {
        $c = new Credentials('k', 's', 'old');
        $derived = $c->withAccessToken('new');
        $this->assertSame('new', $derived->getAccessToken());
        $this->assertSame('old', $c->getAccessToken());
    }
}
