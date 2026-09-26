<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\P4p;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.p4p:alibabaCpsQueryOfferDetailActivity-1
 * 生成自官方 SDK 参数类 AlibabaCpsQueryOfferDetailActivityParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class AlibabaCpsQueryOfferDetailActivityRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.p4p';
    }

    public function getApiName(): string
    {
        return 'alibabaCpsQueryOfferDetailActivity';
    }

    /** 商品id | 示例: 591047134663 */
    public ?int $offerId = null;
}
