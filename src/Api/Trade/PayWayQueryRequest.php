<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.payWayQuery-1
 * 生成自官方 SDK 参数类 AlibabaTradePayWayQueryParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class PayWayQueryRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.payWayQuery';
    }

    /** 订单号 | 示例: 123123 */
    public ?string $orderId = null;
}
