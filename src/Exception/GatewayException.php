<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Exception;

/**
 * 网关级异常：HTTP 非 2xx、响应非 JSON、响应含 gw.* 前缀的 error_code（网关错误，如限流）、网络错误。
 *
 * 业务级失败（error_code 不带 gw. 前缀，如参数校验失败）不抛本异常，
 * 由 Response::isSuccess() 表达，调用方自行判定。
 */
final class GatewayException extends AlibabaOpenException
{
    /** 网络层失败（连接超时、DNS、SSL 等） */
    public const CODE_NETWORK_ERROR = 'NETWORK_ERROR';

    /** 响应体不是合法 JSON */
    public const CODE_MALFORMED_RESPONSE = 'MALFORMED_RESPONSE';

    private string $errorCode;
    private int $httpStatus;
    private ?string $eagleTraceId;
    private bool $rateLimited;

    public function __construct(
        string $message,
        string $errorCode,
        int $httpStatus = 0,
        ?string $eagleTraceId = null,
        bool $rateLimited = false
    ) {
        parent::__construct($message);
        $this->errorCode = $errorCode;
        $this->httpStatus = $httpStatus;
        $this->eagleTraceId = $eagleTraceId;
        $this->rateLimited = $rateLimited;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getEagleTraceId(): ?string
    {
        return $this->eagleTraceId;
    }

    /** 是否为限流错误（gw.QosRequestLimit），唯一触发自动重试的开关 */
    public function isRateLimited(): bool
    {
        return $this->rateLimited;
    }
}
