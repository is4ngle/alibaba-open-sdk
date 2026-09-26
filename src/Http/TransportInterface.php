<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Http;

use Is4ngle\AlibabaOpen\Exception\GatewayException;

/**
 * HTTP 传输抽象：实现负责发起 POST application/x-www-form-urlencoded 请求。
 *
 * 网络层失败（连接超时、DNS、SSL 等）应抛 GatewayException(CODE_NETWORK_ERROR)，不得静默。
 */
interface TransportInterface
{
    /**
     * @param array<string, string> $formParams
     * @param array<string, string> $headers
     * @param float $connectTimeout
     * @throws GatewayException
     */
    public function post(
        string $url,
        array $formParams,
        float $timeout,
        float $connectTimeout,
        array $headers = []
    ): TransportResult;
}
