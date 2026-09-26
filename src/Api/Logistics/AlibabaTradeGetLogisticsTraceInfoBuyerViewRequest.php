<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:alibaba.trade.getLogisticsTraceInfo.buyerView-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetLogisticsTraceInfoBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaTradeGetLogisticsTraceInfoBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.getLogisticsTraceInfo.buyerView';
    }

    /** 该订单下的物流编号 | 示例: AL8234243 */
    public ?string $logisticsId = null;
    /** 订单号 | 示例: 13342343 */
    public ?int $orderId = null;
    /** 是1688业务还是icbu业务 | 示例: 1688或者alibaba */
    public ?string $webSite = null;
}
