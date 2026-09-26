<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.accountPeriodListBuyerView-1
 * 生成自官方 SDK 参数类 AlibabaAccountPeriodListBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaAccountPeriodListBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.accountPeriodListBuyerView';
    }

    /** 页码 | 示例: 1 */
    public ?int $pageIndex = null;
    /** 卖家ID，不填则查询全部 | 示例: alitestforisv01 */
    public ?string $sellerLoginId = null;
}
