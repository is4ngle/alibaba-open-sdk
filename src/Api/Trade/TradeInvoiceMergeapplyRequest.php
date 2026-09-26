<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:tradeInvoiceMergeapply-1
 * 生成自官方 SDK 参数类 TradeInvoiceMergeapplyParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class TradeInvoiceMergeapplyRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'tradeInvoiceMergeapply';
    }

    /** 发票类型 | 示例: 1:普票，2：专票 */
    public ?string $invoiceType = null;
    /** 登录用户id | 示例: xxx */
    public ?int $loginUserId = null;
    /** 合并开票分组列表（每个分组对应一张票),每个分组逗号分隔的字符串 | 示例: ["123,456,789","101,202"] */
    public ?string $orderIdGroupsJsonList = null;
    /** 购方抬头对象 | 示例: 对象 | 嵌套模型: AlibabaChinaAppInvoiceCommonModelInvoiceTitleInvoiceTitleModel */
    public ?array $purchaserInvoiceTitle = null;

    protected function wrapKey(): ?string
    {
        return 'reqDTO';
    }
}
