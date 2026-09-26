<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Ai;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.ai:open.agent.deepSearch-1
 * 生成自官方 SDK 参数类 OpenAgentDeepSearchParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class OpenAgentDeepSearchRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.ai';
    }

    public function getApiName(): string
    {
        return 'open.agent.deepSearch';
    }


}
