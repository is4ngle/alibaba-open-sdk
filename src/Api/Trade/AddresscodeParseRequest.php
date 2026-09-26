<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.addresscode.parse-1
 * 生成自官方 SDK 参数类 AlibabaTradeAddresscodeParseParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AddresscodeParseRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.addresscode.parse';
    }

    /** 地址信息 | 示例: 浙江省 杭州市 滨江区网商路699号 */
    public ?string $addressInfo = null;
    /** 地址解析等级，比如 3 级到区还是 4 级到街道乡镇.默认 3 级 | 示例: 3 */
    public ?string $addressLevel = null;
}
