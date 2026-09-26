<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.get.buyerView-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class GetBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.get.buyerView';
    }

    /** 站点信息，指定调用的API是属于国际站（alibaba）还是1688网站（1688） | 示例: 1688 */
    public ?string $webSite = null;
    /** 交易的订单id | 示例: 123456 */
    public ?int $orderId = null;
    /** 查询结果中包含的域，GuaranteesTerms：保障条款，NativeLogistics：物流信息，RateDetail：评价详情，OrderInvoice：发票信息。默认返回GuaranteesTerms、NativeLogistics、OrderInvoice。InvoicingSetting-开票设置 | 示例: GuaranteesTerms,NativeLogistics,RateDetail,OrderInvoice */
    public ?string $includeFields = null;
    /** 垂直表中的attributeKeys | 示例: [] */
    public ?array $attributeKeys = null;
    /** 外部订单id，控制幂等 | 示例: 1556246 */
    public ?string $outOrderId = null;
}
