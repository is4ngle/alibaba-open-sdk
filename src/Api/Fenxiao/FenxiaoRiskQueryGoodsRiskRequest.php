<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiaoRiskQueryGoodsRisk-1
 * 生成自官方 SDK 参数类 FenxiaoRiskQueryGoodsRiskParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class FenxiaoRiskQueryGoodsRiskRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiaoRiskQueryGoodsRisk';
    }

    /** 当日新发布的商品数量(T+1时间) | 示例: 30 */
    public ?int $publishCount = null;
    /** 截止目前在售有效商品数量 | 示例: 4000 */
    public ?int $onCount = null;

    protected function wrapKey(): ?string
    {
        return 'goodsRiskQueryParam';
    }
}
