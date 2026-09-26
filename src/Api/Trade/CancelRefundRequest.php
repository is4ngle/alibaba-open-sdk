<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.cancelRefund-1
 * 生成自官方 SDK 参数类 AlibabaTradeCancelRefundParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class CancelRefundRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.cancelRefund';
    }

    /** 退款单id | 示例: TQ267395256051660259 */
    public ?string $refundId = null;
}
