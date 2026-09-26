<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen;

use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Config\Options;
use Is4ngle\AlibabaOpen\Exception\GatewayException;
use Is4ngle\AlibabaOpen\Http\GuzzleTransport;
use Is4ngle\AlibabaOpen\Http\TransportInterface;
use Is4ngle\AlibabaOpen\Retry\RateLimitBackoff;
use Is4ngle\AlibabaOpen\Sign\AopSigner;

/**
 * 1688 开放平台通用网关客户端。
 *
 * 调用流程（对齐官方 AOP param2 协议）：
 *  1. URL = {gatewayUrl}/openapi/param2/{version}/{namespace}/{apiName}/{appKey}，POST form-urlencoded；
 *  2. 业务参数中的数组/对象先 json_encode（签名与传输看到同一字符串），null 剔除；
 *  3. 注入公共参数 access_token / _aop_datatype / _aop_timestamp（毫秒）后签名；
 *  4. 限流（gw.QosRequestLimit）自动指数退避重试；
 *  5. 响应分层：网关级错误抛 GatewayException；业务级失败不抛，由 Response::isSuccess() 表达。
 *
 * 本类只做协议层，不封装任何业务 API——业务语义由本包 Api/ 下的 Request 类或宿主项目组装。
 */
final class Client
{
    private Credentials $credentials;
    private Options $options;
    private TransportInterface $transport;
    private RateLimitBackoff $backoff;
    /** @var callable|null fn(): string 毫秒时间戳，测试可注入固定值 */
    private $clock;

    public function __construct(
        Credentials $credentials,
        ?Options $options = null,
        ?TransportInterface $transport = null,
        ?RateLimitBackoff $backoff = null,
        ?callable $clock = null
    ) {
        $this->credentials = $credentials;
        $this->options = $options ?? new Options();
        $this->transport = $transport ?? new GuzzleTransport();
        $this->backoff = $backoff ?? new RateLimitBackoff(
            $this->options->getMaxRetries(),
            $this->options->getBaseDelayMs(),
            $this->options->getMaxDelayMs()
        );
        $this->clock = $clock ?? static fn(): string => (string)intval(microtime(true) * 1000);
    }

    /**
     * 通用入口：调用任意 1688 OpenAPI。
     *
     * @param string $namespace 命名空间，如 com.alibaba.trade
     * @param string $apiName API 名，如 alibaba.trade.getBuyerOrderList
     * @param array<string, mixed> $bizParams 业务参数（数组/对象值自动 json_encode）
     * @param string|null $accessToken 覆盖凭证中的 token（多账号场景）
     * @param string $unwrap 响应剥壳模式 Response::UNWRAP_*
     */
    public function call(
        string $namespace,
        string $apiName,
        int $version = 1,
        array $bizParams = [],
        ?string $accessToken = null,
        string $unwrap = Response::UNWRAP_AUTO
    ): Response {
        $prepared = $this->prepare($namespace, $apiName, $version, $bizParams, $accessToken);

        // 网关错误检测（含 200 + gw.* 错误码的限流）在 backoff 内部执行，使限流可自动重试
        $raw = $this->backoff->execute(
            function () use ($prepared): array {
                $result = $this->transport->post(
                    $prepared['url'],
                    $prepared['form_params'],
                    $this->options->getTimeout(),
                    $this->options->getConnectTimeout()
                );
                $raw = $this->decodeBody($result->getBody(), $result->getStatus());
                $this->assertNotGatewayError($raw, $result->getStatus());
                return $raw;
            }
        );

        $this->options->getLogger()->debug('1688 openapi call ok', [
            'api' => $namespace . ':' . $apiName . '-' . $version,
        ]);

        return (new Response($raw))->unwrap($unwrap);
    }

    /**
     * 字符串式入口（人工调试友好）：解析 "namespace:apiName-version"。
     * 示例：$client->raw('com.alibaba.trade:alibaba.trade.getBuyerOrderList-1', ['page' => 1])
     *
     * @param array<string, mixed> $bizParams
     */
    public function raw(string $nsApiVersion, array $bizParams = []): Response
    {
        [$namespace, $apiName, $version] = self::parseApi($nsApiVersion);
        return $this->call($namespace, $apiName, $version, $bizParams);
    }

    /**
     * Request 对象入口（业务 API 推荐用法）：参数在 Request 类上平铺设置，
     * 包裹键/嵌套 JSON 由 AbstractRequest::toParams() 与本方法协作处理。
     *
     * 响应保持原始结构（UNWRAP_NEVER），由 Response::result() 按需剥壳
     * （代发包统一 {result, success, errorCode, errorMsg} 包裹）。
     */
    public function execute(\Is4ngle\AlibabaOpen\Request\AbstractRequest $request, ?string $accessToken = null): Response
    {
        return $this->call(
            $request->getNamespace(),
            $request->getApiName(),
            $request->getVersion(),
            $request->toParams(),
            $accessToken,
            Response::UNWRAP_NEVER
        );
    }

    /**
     * 解析 "namespace:apiName-version"（版本可省略，默认 1）。
     *
     * @return array{0: string, 1: string, 2: int}
     */
    public static function parseApi(string $nsApiVersion): array
    {
        if (!preg_match('/^([^:]+):([^-]+)(?:-(\d+))?$/', trim($nsApiVersion), $m)) {
            throw new \InvalidArgumentException(
                'API 标识格式错误，应为 "namespace:apiName-version"，如 "com.alibaba.trade:alibaba.trade.getBuyerOrderList-1"，实际: ' . $nsApiVersion
            );
        }
        return [$m[1], $m[2], (int)($m[3] ?? 1)];
    }

    /**
     * 组装请求（签名后不发送）——供调试入口展示签名细节，也便于测试断言。
     *
     * @return array{url: string, api_path: string, form_params: array<string, string>, timestamp: string}
     */
    public function prepare(
        string $namespace,
        string $apiName,
        int $version = 1,
        array $bizParams = [],
        ?string $accessToken = null
    ): array {
        $appKey = $this->credentials->getAppKey();
        $appSecret = $this->credentials->getAppSecret();

        $flatParams = [];
        foreach ($bizParams as $key => $value) {
            if ($value === null) {
                continue;
            }
            if (is_array($value)) {
                $flatParams[(string)$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
            } elseif (is_bool($value)) {
                $flatParams[(string)$key] = $value ? 'true' : 'false';
            } else {
                $flatParams[(string)$key] = (string)$value;
            }
        }

        $token = $accessToken ?? $this->credentials->getAccessToken();
        $timestamp = ($this->clock)();

        $formParams = AopSigner::signRequest(
            $namespace,
            $apiName,
            $appKey,
            $appSecret,
            $token,
            $flatParams,
            $timestamp,
            $version
        );

        $url = sprintf(
            '%s/openapi/param2/%d/%s/%s/%s',
            $this->options->getGatewayUrl(),
            $version,
            $namespace,
            $apiName,
            $appKey
        );

        return [
            'url' => $url,
            'api_path' => AopSigner::buildApiPath($namespace, $apiName, $appKey, $version),
            'form_params' => $formParams,
            'timestamp' => $timestamp,
        ];
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function getOptions(): Options
    {
        return $this->options;
    }

    /** @return array<string, mixed> */
    private function decodeBody(string $body, int $httpStatus): array
    {
        if ($body === '') {
            throw new GatewayException(
                "网关返回空响应（HTTP {$httpStatus}）",
                GatewayException::CODE_MALFORMED_RESPONSE,
                $httpStatus
            );
        }
        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            throw new GatewayException(
                '网关响应非 JSON: ' . mb_substr($body, 0, 200),
                GatewayException::CODE_MALFORMED_RESPONSE,
                $httpStatus
            );
        }
        return $decoded;
    }

    /** @param array<string, mixed> $raw */
    private function assertNotGatewayError(array $raw, int $httpStatus): void
    {
        $errorCode = $raw['error_code'] ?? null;
        if (is_string($errorCode) && strpos($errorCode, 'gw.') === 0) {
            $message = (string)($raw['error_message'] ?? $raw['errorMessage'] ?? $raw['message'] ?? '网关错误');
            throw new GatewayException(
                $message,
                $errorCode,
                $httpStatus,
                isset($raw['eagleTraceId']) ? (string)$raw['eagleTraceId'] : null,
                $errorCode === 'gw.QosRequestLimit'
            );
        }
        // HTTP 非 2xx 且无 gw.* 错误码：仍按网关级错误抛出
        if ($httpStatus < 200 || $httpStatus >= 300) {
            $message = (string)($raw['error_message'] ?? $raw['errorMessage'] ?? $raw['message'] ?? ('HTTP ' . $httpStatus));
            throw new GatewayException(
                $message,
                (string)($raw['error_code'] ?? ('HTTP_' . $httpStatus)),
                $httpStatus,
                isset($raw['eagleTraceId']) ? (string)$raw['eagleTraceId'] : null
            );
        }
    }
}
