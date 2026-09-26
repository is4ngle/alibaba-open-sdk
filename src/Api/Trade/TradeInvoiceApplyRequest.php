<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoice.apply-1
 * 生成自官方 SDK 参数类 TradeInvoiceApplyParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceApplyRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoice.apply';
    }

    /** 发票申请模型 | 示例: {} */
    public ?array $invoiceApplyModelList = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
