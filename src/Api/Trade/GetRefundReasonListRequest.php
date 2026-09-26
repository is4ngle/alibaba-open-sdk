<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.getRefundReasonList-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetRefundReasonListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class GetRefundReasonListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.getRefundReasonList';
    }

    /** 主订单id */
    public ?int $orderId = null;
    /** 子订单id */
    public ?array $orderEntryIds = null;
    /** 货物状态 | 示例: 售中等待买家发货:”refundWaitSellerSend"; 售中等待买家收货:"refundWaitBuyerReceive"; 售中已收货（未确认完成交易）:"refundBuyerReceived" 售后未收货:"aftersaleBuyerNotReceived"; 售后已收到货:"aftersaleBuyerReceived" */
    public ?string $goodsStatus = null;
}
