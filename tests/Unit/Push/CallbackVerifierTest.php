<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Push;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Exception\PushException;
use Is4ngle\AlibabaOpen\Push\Callback\CallbackVerifier;

final class CallbackVerifierTest extends TestCase
{
    private const SECRET = 'secretXYZ';

    private function message(): array
    {
        return [
            'msgId' => '1001',
            'gmtBorn' => '1700000000000',
            'type' => 'ORDER_CHANGED',
            'userInfo' => 'm1',
            'data' => '{"orderId":"123","status":"paid"}',
            'bizKey' => '123',
        ];
    }

    public function testParseAndVerifyOk(): void
    {
        $params = CallbackVerifier::fakeSignedParams($this->message(), self::SECRET);
        $msg = CallbackVerifier::parseAndVerify($params, self::SECRET);

        $this->assertSame('1001', $msg->getMsgId());
        $this->assertSame(1700000000000, $msg->getGmtBorn());
        $this->assertSame('ORDER_CHANGED', $msg->getType());
        $this->assertSame('m1', $msg->getUserInfo());
        $this->assertSame(['orderId' => '123', 'status' => 'paid'], $msg->getData());
        $this->assertSame('123', $msg->getBizKey());
    }

    public function testTamperedBodyThrows(): void
    {
        $params = CallbackVerifier::fakeSignedParams($this->message(), self::SECRET);
        $params['msgId'] = '9999';

        $this->expectException(PushException::class);
        CallbackVerifier::parseAndVerify($params, self::SECRET);
    }

    public function testMissingSignatureThrows(): void
    {
        $this->expectException(PushException::class);
        CallbackVerifier::parseAndVerify($this->message(), self::SECRET);
    }

    public function testMissingMsgIdThrows(): void
    {
        $params = CallbackVerifier::fakeSignedParams(['type' => 'X'], self::SECRET);
        // 去掉 msgId 再重签
        unset($params['msgId']);
        $params = CallbackVerifier::fakeSignedParams($params, self::SECRET);

        $this->expectException(PushException::class);
        CallbackVerifier::parseAndVerify($params, self::SECRET);
    }

    public function testArrayDataAcceptedDirectly(): void
    {
        $msg = CallbackVerifier::parse([
            'msgId' => '1',
            'gmtBorn' => 1,
            'type' => 'T',
            'userInfo' => 'u',
            'data' => ['k' => 'v'],
        ]);
        $this->assertSame(['k' => 'v'], $msg->getData());
    }
}
