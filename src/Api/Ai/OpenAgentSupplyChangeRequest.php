<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Ai;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.ai:open.agent.supplyChange-1
 * 生成自官方 SDK 参数类 OpenAgentSupplyChangeParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class OpenAgentSupplyChangeRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.ai';
    }

    public function getApiName(): string
    {
        return 'open.agent.supplyChange';
    }

    /** 批次id | 示例: 123456 */
    public ?string $batchId = null;
    /** 具体入参信息 | 示例: 123456 */
    public ?array $supplyChangeDatas = null;
}
