<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.refund.OpQueryOrderRefundOperationList-1
 * 生成自官方 SDK 参数类 AlibabaTradeRefundOpQueryOrderRefundOperationListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RefundOpQueryOrderRefundOperationListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.refund.OpQueryOrderRefundOperationList';
    }

    /** 退款单Id | 示例: TQ1043162**46961198 */
    public ?string $refundId = null;
    /** 当前页号 | 示例: 1 */
    public ?string $pageNo = null;
    /** 页大小 | 示例: 100 */
    public ?string $pageSize = null;
}
