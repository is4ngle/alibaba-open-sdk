<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Integration;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Client;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Exception\GatewayException;
use Is4ngle\AlibabaOpen\Http\GuzzleTransport;
use Is4ngle\AlibabaOpen\Retry\RateLimitBackoff;
use Is4ngle\AlibabaOpen\Sign\AopSigner;

/**
 * 网关集成测试：Guzzle MockHandler 驱动 Client 全链路（不 mock Client 本身）。
 */
final class MockGatewayTest extends TestCase
{
    private Credentials $credentials;

    protected function setUp(): void
    {
        $this->credentials = new Credentials('1234567', 'secretXYZ', 'tok-abc');
    }

    private function client(MockHandler $mock): Client
    {
        $transport = new GuzzleTransport(new GuzzleClient(['handler' => HandlerStack::create($mock), 'verify' => true]));
        $backoff = new RateLimitBackoff(3, 1, 1, function () {});
        return new Client($this->credentials, null, $transport, $backoff, fn(): string => '1700000000000');
    }

    public function testCallSuccessWithResultWrap(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['result' => ['total' => 1, 'list' => [['orderId' => 'o1']]]])),
        ]);
        $client = $this->client($mock);

        $resp = $client->call('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1, ['page' => 1]);

        $this->assertTrue($resp->isSuccess());
        $this->assertSame(['total' => 1, 'list' => [['orderId' => 'o1']]], $resp->getData());

        // URL 断言
        $uri = $mock->getLastRequest()->getUri();
        $this->assertSame('gw.open.1688.com', $uri->getHost());
        $this->assertSame('/openapi/param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567', $uri->getPath());
    }

    public function testCallSendsSignedFormBody(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['result' => []])),
        ]);
        $client = $this->client($mock);

        $client->call('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1, ['page' => 1, 'bizTypes' => ['cn_common']]);

        parse_str((string)$mock->getLastRequest()->getBody(), $form);
        $this->assertSame('tok-abc', $form['access_token']);
        $this->assertSame('application/json', $form['_aop_datatype']);
        $this->assertSame('1700000000000', $form['_aop_timestamp']);
        // 数组参数以 JSON 串传输
        $this->assertSame('["cn_common"]', $form['bizTypes']);
        // 签名自洽：用 AopSigner 重算比对
        $signature = $form['_aop_signature'];
        unset($form['_aop_signature']);
        $expected = AopSigner::sign(
            'param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567',
            $form,
            'secretXYZ'
        );
        $this->assertSame($expected, $signature);
    }

    public function testRetriesOnRateLimitThenSucceeds(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['error_code' => 'gw.QosRequestLimit', 'error_message' => 'limit'])),
            new Response(200, [], json_encode(['result' => ['ok' => true]])),
        ]);
        $client = $this->client($mock);

        $resp = $client->call('ns', 'api', 1, []);
        $this->assertSame(['ok' => true], $resp->getData());
        // MockHandler::count() 为剩余队列数：2 条全部消费完毕
        $this->assertSame(0, $mock->count());
    }

    public function testRateLimitExhaustedThrowsGatewayException(): void
    {
        $mock = new MockHandler(array_fill(0, 4, new Response(200, [], json_encode(['error_code' => 'gw.QosRequestLimit', 'error_message' => 'limit']))));
        $client = $this->client($mock);

        try {
            $client->call('ns', 'api', 1, []);
            $this->fail('应抛出 GatewayException');
        } catch (GatewayException $e) {
            $this->assertSame('gw.QosRequestLimit', $e->getErrorCode());
            $this->assertTrue($e->isRateLimited());
        }
        // 1 原始 + 3 重试 = 4 条全部消费
        $this->assertSame(0, $mock->count());
    }

    public function testNon2xxThrowsGatewayException(): void
    {
        $mock = new MockHandler([
            new Response(500, [], json_encode(['error_message' => 'server error'])),
        ]);
        $client = $this->client($mock);

        $this->expectException(GatewayException::class);
        $client->call('ns', 'api', 1, []);
    }

    public function testMalformedBodyThrows(): void
    {
        $mock = new MockHandler([
            new Response(200, [], '<html>not json</html>'),
        ]);
        $client = $this->client($mock);

        try {
            $client->call('ns', 'api', 1, []);
            $this->fail('应抛出 GatewayException');
        } catch (GatewayException $e) {
            $this->assertSame(GatewayException::CODE_MALFORMED_RESPONSE, $e->getErrorCode());
        }
    }

    public function testBusinessErrorNotThrown(): void
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['error_code' => 'BA_PARAM_INVALID_ERROR', 'error_message' => '参数非法'])),
        ]);
        $client = $this->client($mock);

        $resp = $client->call('ns', 'api', 1, []);
        $this->assertFalse($resp->isSuccess());
        $this->assertSame('BA_PARAM_INVALID_ERROR', $resp->getErrorCode());
        $this->assertSame('参数非法', $resp->getErrorMessage());
    }

    public function testRawApiStringParsing(): void
    {
        $this->assertSame(['com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1], Client::parseApi('com.alibaba.trade:alibaba.trade.getBuyerOrderList-1'));
        $this->assertSame(['ns', 'api', 1], Client::parseApi('ns:api'));
        $this->expectException(\InvalidArgumentException::class);
        Client::parseApi('invalid');
    }

    public function testPrepareExposesRequestDetailsForDebug(): void
    {
        $client = $this->client(new MockHandler());
        $prepared = $client->prepare('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1, ['page' => 1]);

        $this->assertSame('https://gw.open.1688.com/openapi/param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567', $prepared['url']);
        $this->assertSame('param2/1/com.alibaba.trade/alibaba.trade.getBuyerOrderList/1234567', $prepared['api_path']);
        $this->assertSame('1700000000000', $prepared['timestamp']);
        $this->assertArrayHasKey('_aop_signature', $prepared['form_params']);
    }
}
