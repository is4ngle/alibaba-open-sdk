<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.refundOpQueryOrderRefund-1
 * 生成自官方 SDK 参数类 AlibabaTradeRefundOpQueryOrderRefundParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RefundOpQueryOrderRefundRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.refundOpQueryOrderRefund';
    }

    /** 退款单业务主键 TQ+ID | 示例: TQ11173622***991577 */
    public ?string $refundId = null;
    /** 需要退款单的超时信息 | 示例: true */
    public ?bool $needTimeOutInfo = null;
    /** 需要退款单伴随的所有退款操作信息 | 示例: true */
    public ?bool $needOrderRefundOperation = null;
}
