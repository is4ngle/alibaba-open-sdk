<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:supply.task.stop-1
 * 生成自官方 SDK 参数类 SupplyTaskStopParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class SupplyTaskStopRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'supply.task.stop';
    }

    /** 任务标识 | 示例: sdfek35dssf356m57m */
    public ?string $taskId = null;
}
