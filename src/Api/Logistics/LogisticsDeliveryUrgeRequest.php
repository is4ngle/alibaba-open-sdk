<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:logistics.deliveryUrge-1
 * 生成自官方 SDK 参数类 LogisticsDeliveryUrgeParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class LogisticsDeliveryUrgeRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'logistics.deliveryUrge';
    }

    /** 订单id | 示例: 12898772891323 */
    public ?string $orderId = null;
}
