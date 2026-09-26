<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Ai;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.ai:open.agent.supplyChangeDataFeedback-1
 * 生成自官方 SDK 参数类 OpenAgentSupplyChangeDataFeedbackParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class OpenAgentSupplyChangeDataFeedbackRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.ai';
    }

    public function getApiName(): string
    {
        return 'open.agent.supplyChangeDataFeedback';
    }

    /** 外部唯一标识 | 示例: 12345678 */
    public ?string $relationId = null;
    /** 商品id | 示例: 12345678 */
    public ?string $offerId = null;
    /** skuId | 示例: 12345678 */
    public ?string $skuId = null;
    /** 原因 | 示例: 推荐不准确 */
    public ?string $reason = null;
    /** skuName | 示例: 规格名称 */
    public ?string $skuName = null;
    /** 是否被采纳 | 示例: true为采纳，false为不采纳 */
    public ?string $accepted = null;
}
