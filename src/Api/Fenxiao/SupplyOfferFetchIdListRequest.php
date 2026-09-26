<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:supply.offer.fetchIdList-1
 * 生成自官方 SDK 参数类 SupplyOfferFetchIdListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class SupplyOfferFetchIdListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'supply.offer.fetchIdList';
    }

    /** 任务标识 | 示例: 124jnkrdsfsdgs */
    public ?string $taskId = null;
    /** 批次号 | 示例: 1 */
    public ?int $batchNo = null;
    /** 起始位点 | 示例: 100000 */
    public ?string $startIndex = null;
}
