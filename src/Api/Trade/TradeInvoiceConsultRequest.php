<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:tradeInvoiceConsult-1
 * 生成自官方 SDK 参数类 TradeInvoiceConsultParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class TradeInvoiceConsultRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'tradeInvoiceConsult';
    }

    /** 需要咨询的订单列表（JSON字符串） | 示例: ["123","456","789"] */
    public ?string $orderIdsJsonList = null;

    protected function wrapKey(): ?string
    {
        return 'reqDTO';
    }
}
