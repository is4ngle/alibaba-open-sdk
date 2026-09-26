<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Exception;

/**
 * 消息推送通道异常（HTTP 回调验签失败、WS 连接/协议错误等）
 */
final class PushException extends AlibabaOpenException
{
    /** 回调验签不匹配 */
    public const CODE_SIGNATURE_MISMATCH = 'SIGNATURE_MISMATCH';

    /** 回调参数缺失/无法解析 */
    public const CODE_MALFORMED_CALLBACK = 'MALFORMED_CALLBACK';

    private string $errorCode;

    public function __construct(string $message, string $errorCode = '')
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
