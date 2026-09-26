<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Marketing;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.marketing:coupon.optimalClaim-1
 * 生成自官方 SDK 参数类 CouponOptimalClaimParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class CouponOptimalClaimRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.marketing';
    }

    public function getApiName(): string
    {
        return 'coupon.optimalClaim';
    }

    /** 商品id列表 | 示例: [24910983123,2799731973] */
    public ?array $offerIds = null;
}
