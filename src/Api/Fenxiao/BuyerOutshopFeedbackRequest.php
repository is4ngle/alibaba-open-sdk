<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:buyerOutshopFeedback-1
 * 生成自官方 SDK 参数类 BuyerOutshopFeedbackParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class BuyerOutshopFeedbackRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'buyerOutshopFeedback';
    }

    /** 1 | 示例: 123 */
    public ?string $appKey = null;
    /** 1 | 示例: 1 */
    public ?int $buyerId = null;
    /** 1 | 示例: 1 */
    public ?string $channel = null;
    /** 1 | 示例: 1 */
    public ?string $detailFailReason = null;
    /** 1 | 示例: 1 */
    public ?string $failReasonType = null;
    /** 1 | 示例: 1 */
    public ?string $outShopCode = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
