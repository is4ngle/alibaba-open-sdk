<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.getSourcingRequisitionList-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingGetSourcingRequisitionListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingGetSourcingRequisitionListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.getSourcingRequisitionList';
    }

    public ?int $buyerUserId = null;
    /** 嵌套模型: Date */
    public ?array $gmtCreateEnd = null;
    /** 嵌套模型: Date */
    public ?array $gmtCreateStart = null;
    public ?string $orderBy = null;
    public ?string $orderDirection = null;
    public ?int $pageNum = null;
    public ?int $pageSize = null;
    public ?string $requisitionId = null;
    public ?string $requisitionStatus = null;
    public ?string $sourcingType = null;
    /** 需求名称 | 示例: 111 */
    public ?string $requisitionName = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
