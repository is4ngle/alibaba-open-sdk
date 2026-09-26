<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.grouppay.url.get-1
 * 生成自官方 SDK 参数类 AlibabaTradeGrouppayUrlGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class GrouppayUrlGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.grouppay.url.get';
    }

    /** 订单列表 | 示例: [123123413,1223234] */
    public ?array $orderIds = null;
    /** PC或WIRELESS | 示例: PC */
    public ?string $payPlatformType = null;
}
