<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoiceGetListBuyerView-1
 * 生成自官方 SDK 参数类 TradeInvoiceGetListBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceGetListBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoiceGetListBuyerView';
    }


}
