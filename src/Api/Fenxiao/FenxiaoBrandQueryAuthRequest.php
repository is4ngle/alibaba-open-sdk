<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiaoBrandQueryAuth-1
 * 生成自官方 SDK 参数类 FenxiaoBrandQueryAuthParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class FenxiaoBrandQueryAuthRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiaoBrandQueryAuth';
    }

    /** 用户id | 示例: 123 */
    public ?int $buyerId = null;
    /** 下游渠道 | 示例: 比如：淘宝：thyny */
    public ?string $channel = null;
    /** 商品id | 示例: 22222222 */
    public ?int $offerId = null;
    /** 下游店铺code | 示例: 111111 */
    public ?string $outShopCode = null;

    protected function wrapKey(): ?string
    {
        return 'queryRequest';
    }
}
