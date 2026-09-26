<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.addresscode.getchild-1
 * 生成自官方 SDK 参数类 AlibabaTradeAddresscodeGetchildParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AddresscodeGetchildRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.addresscode.getchild';
    }

    /** 地址码，如果不输入则获取最上层信息 | 示例: 330108 */
    public ?string $areaCode = null;
    /** 站点信息,1688或者alibaba | 示例: 1688 */
    public ?string $webSite = null;
}
