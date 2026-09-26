<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit\Sign;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Sign\AopSigner;

/**
 * AOP param2 签名黄金向量测试。
 *
 * 向量算法定义（与 newton Java SDK AopSigner.java、liaosp/ali_open PHP 实现交叉验证一致）：
 * apiPath + 参数按 key 字典序 key+value 拼接（null 跳过）→ HMAC-SHA1(appSecret) → 大写 HEX
 */
final class AopSignerTest extends TestCase
{
    public function testBuildApiPath(): void
    {
        $this->assertSame(
            'param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567',
            AopSigner::buildApiPath('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', '1234567')
        );
        $this->assertSame(
            'param2/2/ns/api/k',
            AopSigner::buildApiPath('ns', 'api', 'k', 2)
        );
    }

    public function testGoldenVector1(): void
    {
        $sign = AopSigner::sign(
            'param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567',
            [
                'access_token' => 'tok-abc',
                '_aop_datatype' => 'application/json',
                '_aop_timestamp' => '1700000000000',
                'page' => '1',
                'pageSize' => '20',
            ],
            'secretXYZ'
        );
        $this->assertSame('D01C12C8FCD4B59367FFDD51E1DEC31C7C237A4C', $sign);
    }

    public function testGoldenVector2ComplexParamAsJsonString(): void
    {
        $sign = AopSigner::sign(
            'param2/1/com.alibaba.agent/newtoncloud.task.create/mykey',
            [
                'access_token' => 'a1',
                '_aop_datatype' => 'application/json',
                '_aop_timestamp' => '1699999999999',
                'message' => 'hello',
                'fileUrls' => '["u1","u2"]',
            ],
            'sk'
        );
        $this->assertSame('AAE1AB7148B81D8EB334345395E71D7338F6BB43', $sign);
    }

    public function testGoldenVector3NullSkipped(): void
    {
        $sign = AopSigner::sign(
            'param2/1/ns/api/k',
            ['a' => null, '_aop_datatype' => 'application/json', '_aop_timestamp' => '1'],
            's'
        );
        // 等价于不含 a 的签名
        $withoutNull = AopSigner::sign(
            'param2/1/ns/api/k',
            ['_aop_datatype' => 'application/json', '_aop_timestamp' => '1'],
            's'
        );
        $this->assertSame($withoutNull, $sign);
        $this->assertSame('207584D75CAB31AC2141CC17D2EAAC3EB016AE42', $sign);
    }

    public function testKeyOrderIndependent(): void
    {
        $a = AopSigner::sign('param2/1/ns/api/k', ['a' => '1', 'b' => '2', 'c' => '3'], 's');
        $b = AopSigner::sign('param2/1/ns/api/k', ['c' => '3', 'a' => '1', 'b' => '2'], 's');
        $this->assertSame($a, $b);
    }

    public function testSignatureIsUppercaseHex(): void
    {
        $sign = AopSigner::sign('param2/1/ns/api/k', ['x' => 'y'], 's');
        $this->assertMatchesRegularExpression('/^[0-9A-F]{40}$/', $sign);
    }

    public function testSignRequestInjectsCommonParamsAndSignature(): void
    {
        $signed = AopSigner::signRequest(
            'com.alibaba.trade',
            'alibaba.trade.getBuyerOrderList',
            '1234567',
            'secretXYZ',
            'tok-abc',
            ['page' => '1'],
            '1700000000000'
        );

        $this->assertSame('application/json', $signed['_aop_datatype']);
        $this->assertSame('1700000000000', $signed['_aop_timestamp']);
        $this->assertSame('tok-abc', $signed['access_token']);
        $this->assertArrayHasKey('_aop_signature', $signed);

        // 签名可自洽复算
        $expected = AopSigner::sign('param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567', [
            'access_token' => 'tok-abc',
            '_aop_datatype' => 'application/json',
            '_aop_timestamp' => '1700000000000',
            'page' => '1',
        ], 'secretXYZ');
        $this->assertSame($expected, $signed['_aop_signature']);
    }

    public function testSignRequestWithoutTokenOmitsAccessToken(): void
    {
        $signed = AopSigner::signRequest('ns', 'api', 'k', 's', null, [], '1');
        $this->assertArrayNotHasKey('access_token', $signed);
    }
}
