<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:alibaba.trade.getLogisticsInfos.buyerView-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetLogisticsInfosBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaTradeGetLogisticsInfosBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.getLogisticsInfos.buyerView';
    }

    /** 订单号 | 示例: 1221434 */
    public ?int $orderId = null;
    /** 需要返回的字段，目前有:company.name,sender,receiver,sendgood。返回的字段要用英文逗号分隔开 | 示例: company,name,sender,receiver,sendgood */
    public ?string $fields = null;
    /** 是1688业务还是icbu业务 | 示例: 1688或者alibaba */
    public ?string $webSite = null;
}
