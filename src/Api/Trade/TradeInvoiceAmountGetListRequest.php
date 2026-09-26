<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoiceAmountGetList-1
 * 生成自官方 SDK 参数类 TradeInvoiceAmountGetListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceAmountGetListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoiceAmountGetList';
    }

    /** 订单ID列表 | 示例: [123, 456] */
    public ?array $orderIds = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
