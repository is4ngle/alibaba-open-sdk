<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.fenxiao.product.info.get-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoProductInfoGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ProductInfoGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.fenxiao.product.info.get';
    }

    /** 1688商品ID | 示例: 573741401425 */
    public ?int $offerId = null;
    /** 1688加密商品ID，跟offerId必选其一 | 示例: ipyyvQsdS1fd/NACddd1Hg== */
    public ?string $openOfferId = null;
    /** 下游租户ID | 示例: 即时零售等场景，下游租户id */
    public ?string $tenantId = null;
}
