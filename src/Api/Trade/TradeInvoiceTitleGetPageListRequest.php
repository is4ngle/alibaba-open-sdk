<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoiceTitleGetPageList-1
 * 生成自官方 SDK 参数类 TradeInvoiceTitleGetPageListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceTitleGetPageListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoiceTitleGetPageList';
    }

    /** 当前页，不能小于1 | 示例: 1 */
    public ?int $page = null;
    /** 分页大小，不能小于1，不能大于100 | 示例: 50 */
    public ?int $pageSize = null;
    /** 抬头名称 | 示例: 抬头名称 */
    public ?string $titleName = null;
    /** 发票抬头类型，个人和社会组织都是PERSONAL：PERSONAL(0,"个人"),COMPANY(1,"企业"),SOCIAL_ORGANIZATION(3,"社会组织（机关事业单位等）"),PARENT_VIRTUAL(-1,"父票虚拟类型"); | 示例: PERSONAL */
    public ?string $titleType = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
