<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.createSourcingRequisition-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingCreateSourcingRequisitionParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingCreateSourcingRequisitionRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.createSourcingRequisition';
    }

    public ?int $buyerUserId = null;
    /** 嵌套模型: Date */
    public ?array $expireTime = null;
    public ?string $requisitionName = null;
    public ?string $requisitionSource = null;
    public ?array $sourcingItemList = null;
    public ?string $sourcingType = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
