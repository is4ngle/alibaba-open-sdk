<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Is4ngle\AlibabaOpen\Response;

final class ResponseTest extends TestCase
{
    public function testUnwrapAutoOnResultWrapped(): void
    {
        $resp = new Response(['result' => ['total' => 5, 'list' => [1, 2]]]);
        $this->assertSame(['total' => 5, 'list' => [1, 2]], $resp->getData());
    }

    public function testUnwrapAutoOnFlatBodyReturnsNull(): void
    {
        $resp = new Response(['success' => true, 'taskId' => 't1']);
        $this->assertNull($resp->getData());
        $this->assertSame(['success' => true, 'taskId' => 't1'], $resp->getRaw());
    }

    public function testUnwrapNever(): void
    {
        $resp = (new Response(['result' => ['a' => 1]]))->unwrap(Response::UNWRAP_NEVER);
        $this->assertNull($resp->getData());
    }

    public function testUnwrapAlways(): void
    {
        $resp = (new Response(['result' => ['a' => 1]]))->unwrap(Response::UNWRAP_ALWAYS);
        $this->assertSame(['a' => 1], $resp->getData());
    }

    public function testUnwrapDoesNotMutateOriginal(): void
    {
        $resp = new Response(['result' => ['a' => 1]]);
        $resp->unwrap(Response::UNWRAP_NEVER);
        $this->assertSame(['a' => 1], $resp->getData());
    }

    public function testIsSuccess(): void
    {
        $this->assertTrue((new Response(['result' => []]))->isSuccess());
        $this->assertTrue((new Response(['success' => true]))->isSuccess());
        $this->assertFalse((new Response(['error_code' => 'BA_PARAM_INVALID_ERROR', 'error_message' => 'bad']))->isSuccess());
        $this->assertFalse((new Response(['errorMessage' => 'boom']))->isSuccess());
        // message 字段单独存在不算失败（部分成功响应携带 message）
        $this->assertTrue((new Response(['message' => 'ok']))->isSuccess());
    }

    public function testErrorAccessors(): void
    {
        $resp = new Response([
            'error_code' => 'BA_PARAM_INVALID_ERROR',
            'error_message' => '参数非法',
            'eagleTraceId' => 'eagle-1',
        ]);
        $this->assertSame('BA_PARAM_INVALID_ERROR', $resp->getErrorCode());
        $this->assertSame('参数非法', $resp->getErrorMessage());
        $this->assertSame('eagle-1', $resp->getEagleTraceId());
    }

    public function testErrorMessageFallsBackAcrossFieldNames(): void
    {
        $this->assertSame('m1', (new Response(['message' => 'm1']))->getErrorMessage());
        $this->assertSame('m2', (new Response(['errorMessage' => 'm2']))->getErrorMessage());
        $this->assertSame('m3', (new Response(['error_message' => 'm3']))->getErrorMessage());
        $this->assertNull((new Response([]))->getErrorMessage());
    }
}
