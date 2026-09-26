<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\WebSocket;

/**
 * WebSocket 业务消息消费接口。
 *
 * 返回 true 表示消费成功（SDK 将向平台发送 CONFIRM 回执）；
 * 返回 false 或抛出异常表示消费失败（不 confirm，平台将择机重发，消费方须按 msgId 幂等）。
 */
interface WsHandlerInterface
{
    public function onMessage(WsMessage $message): bool;
}
