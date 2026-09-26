<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Is4ngle\AlibabaOpen\Exception\GatewayException;

/**
 * Guzzle 7 传输实现。
 *
 * 安全约束：强制开启 SSL 证书校验（verify=true），禁止关闭——旧式封装关闭校验属重大安全隐患，本 SDK 不提供该选项。
 */
final class GuzzleTransport implements TransportInterface
{
    private Client $client;

    public function __construct(?Client $client = null)
    {
        $this->client = $client ?? new Client(['verify' => true]);
    }

    public function post(
        string $url,
        array $formParams,
        float $timeout,
        float $connectTimeout,
        array $headers = []
    ): TransportResult {
        try {
            $response = $this->client->request('POST', $url, [
                'form_params' => $formParams,
                'headers' => $headers,
                'timeout' => $timeout,
                'connect_timeout' => $connectTimeout,
                'verify' => true,
                'http_errors' => false, // 非 2xx 不抛异常，由上层统一判定
            ]);
        } catch (ConnectException $e) {
            throw new GatewayException(
                '网络连接失败: ' . $e->getMessage(),
                GatewayException::CODE_NETWORK_ERROR
            );
        } catch (TransferException $e) {
            // GuzzleException/TransferException 其余传输层错误
            throw new GatewayException(
                'HTTP 传输失败: ' . $e->getMessage(),
                GatewayException::CODE_NETWORK_ERROR
            );
        }

        $rawHeaders = [];
        foreach ($response->getHeaders() as $name => $values) {
            $rawHeaders[strtolower((string)$name)] = implode(', ', $values);
        }

        return new TransportResult(
            $response->getStatusCode(),
            (string)$response->getBody(),
            $rawHeaders
        );
    }
}
