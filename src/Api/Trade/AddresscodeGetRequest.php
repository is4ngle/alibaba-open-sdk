<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.addresscode.get-1
 * 生成自官方 SDK 参数类 AlibabaTradeAddresscodeGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AddresscodeGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.addresscode.get';
    }

    /** 地址code码 | 示例: 330108 */
    public ?string $areaCode = null;
    /** 站点信息，指定调用的API是属于国际站（alibaba）还是1688网站（1688） | 示例: 1688 */
    public ?string $webSite = null;
}
