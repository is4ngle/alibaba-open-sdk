<?php
/**
 * HTTP 回调验签示例（框架无关：宿主 controller 把 query+form 参数合并传入即可）
 */

require __DIR__ . '/../vendor/autoload.php';

use Is4ngle\AlibabaOpen\Exception\PushException;
use Is4ngle\AlibabaOpen\Push\Callback\CallbackVerifier;

// 例：Laravel/ThinkPHP/FPM 中，取 query + POST form 合并
$params = array_merge($_GET, $_POST);

try {
    $message = CallbackVerifier::parseAndVerify($params, 'your-app-secret');
} catch (PushException $e) {
    // 验签失败：按官方约定返回 401
    http_response_code(401);
    exit;
}

// 处理消息（注意按 msgId 幂等——平台会对未确认的消息重发）
// $message->getMsgId() / getType() / getData() / getUserInfo() / getBizKey() / getGmtBorn()
error_log(sprintf(
    '1688 push: msgId=%s type=%s data=%s',
    $message->getMsgId(),
    $message->getType(),
    json_encode($message->getData(), JSON_UNESCAPED_UNICODE)
));

// 处理成功返回 204（如平台要求 200+响应体请自行调整）
http_response_code(204);

// ---- 本地自测：模拟一条带正确签名的推送 ----
// $fake = CallbackVerifier::fakeSignedParams([
//     'msgId' => 'test-1',
//     'type' => 'ORDER_STATUS_CHANGED',
//     'data' => json_encode(['orderId' => '123']),
// ], 'your-app-secret');
// var_export($fake);
