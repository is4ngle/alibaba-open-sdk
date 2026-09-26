<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Product;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.product:alibaba.product.unfollowCrossborder-1
 * 生成自官方 SDK 参数类 AlibabaProductUnfollowCrossborderParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class UnfollowCrossborderRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.product';
    }

    public function getApiName(): string
    {
        return 'alibaba.product.unfollowCrossborder';
    }

    /** 商品id | 示例: 36143645361 */
    public ?int $productId = null;
}
