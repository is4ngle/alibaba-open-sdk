<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.getMaxRefundFee-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetMaxRefundFeeParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class GetMaxRefundFeeRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.getMaxRefundFee';
    }

    /** 货物状态 | 示例: 售中等待卖家发货:"refundWaitSellerSend"; 售中等待买家收货:"refundWaitBuyerReceive"; 售中已收货（未确认完成交易）:"refundBuyerReceived" 售后未收货:"aftersaleBuyerNotReceived"; 售后已收到货:"aftersaleBuyerReceived" */
    public ?string $goodsStatus = null;
    /** 订单ID | 示例: 123 */
    public ?int $orderId = null;
    /** 退款单必须处于退款中，可不传 | 示例: TQ123 */
    public ?string $refundId = null;
    /** 退货数量 | 示例: [{1: 1}] */
    public ?array $refundGoodsCountList = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
