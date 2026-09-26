<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.refund.OpQueryBatchRefundByOrderIdAndStatus-1
 * 生成自官方 SDK 参数类 AlibabaTradeRefundOpQueryBatchRefundByOrderIdAndStatusParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RefundOpQueryBatchRefundByOrderIdAndStatusRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.refund.OpQueryBatchRefundByOrderIdAndStatus';
    }

    /** 订单id | 示例: 151267031**8969811 */
    public ?string $orderId = null;
    /** 1：活动；3:退款成功（只支持退款中和退款成功） | 示例: 3 */
    public ?string $queryType = null;
}
