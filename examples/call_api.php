<?php
/**
 * 通用网关调用示例（独立运行，无框架依赖）
 *
 * php examples/call_api.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Is4ngle\AlibabaOpen\Client;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Config\Options;

$credentials = new Credentials(
    getenv('ALIOPEN_APP_KEY') ?: 'your-app-key',
    getenv('ALIOPEN_APP_SECRET') ?: 'your-app-secret',
    getenv('ALIOPEN_ACCESS_TOKEN') ?: 'your-access-token'
);

$client = new Client($credentials, new Options(
    'https://gw.open.1688.com', // gatewayUrl
    10.0,                       // timeout
    5.0                         // connectTimeout
));

// 方式一：任意 API（ns, apiName, version, bizParams）
try {
    $resp = $client->call('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1, [
        'page' => 1,
        'pageSize' => 20,
    ]);
} catch (\Is4ngle\AlibabaOpen\Exception\GatewayException $e) {
    // 网关级错误：HTTP 非 2xx / gw.* 错误码（含限流重试耗尽）/ 网络失败 / 非 JSON
    fwrite(STDERR, sprintf(
        "GatewayException: %s (code=%s, http=%d, trace=%s)\n",
        $e->getMessage(),
        $e->getErrorCode(),
        $e->getHttpStatus(),
        $e->getEagleTraceId() ?? '-'
    ));
    exit(1);
}

// 业务级失败不抛异常
if (!$resp->isSuccess()) {
    fwrite(STDERR, "业务失败: {$resp->getErrorCode()} {$resp->getErrorMessage()}\n");
    exit(1);
}

var_export($resp->getData() ?? $resp->getRaw());

// 方式二：字符串式（人工调试友好）
// $resp = $client->raw('com.alibaba.trade:alibaba.trade.getBuyerOrderList-1', ['page' => 1]);
