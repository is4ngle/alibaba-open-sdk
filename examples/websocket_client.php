<?php
/**
 * WebSocket 推送消费示例（独立运行，无框架依赖）
 *
 * php examples/websocket_client.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Push\WebSocket\StreamSocketTransport;
use Is4ngle\AlibabaOpen\Push\WebSocket\WsClient;
use Is4ngle\AlibabaOpen\Push\WebSocket\WsHandlerInterface;
use Is4ngle\AlibabaOpen\Push\WebSocket\WsMessage;

$credentials = new Credentials(
    getenv('ALIOPEN_APP_KEY') ?: 'your-app-key',
    getenv('ALIOPEN_APP_SECRET') ?: 'your-app-secret'
);

// 返回 true = 确认消费（回 CONFIRM）；false/抛异常 = 平台将重发（务必按 msgId 幂等）
$handler = new class implements WsHandlerInterface {
    public function onMessage(WsMessage $message): bool
    {
        echo '[PUSH] ', json_encode($message->getRaw(), JSON_UNESCAPED_UNICODE), PHP_EOL;
        return true;
    }
};

$client = new WsClient(
    $credentials,
    $handler,
    new StreamSocketTransport(),   // 纯 PHP 传输层；生产可换 SwooleCoroutineTransport（suggest ext-swoole）
    null,
    null,
    [
        'ws_url' => 'ws://message.1688.com/websocket',
        // 'max_runtime_sec' => 60.0,  // 调试用：运行 60 秒自动退出；常驻进程不配置
    ]
);

// Ctrl+C 或 SIGTERM 可中断
pcntl_async_signals(true);
pcntl_signal(SIGTERM, fn() => $client->stop());
pcntl_signal(SIGINT, fn() => $client->stop());

$client->loop();   // 阻塞式：连接 -> CONNECT/ACK -> 30s 心跳 -> 收推送 -> CONFIRM -> 断线 10s 自动重连
