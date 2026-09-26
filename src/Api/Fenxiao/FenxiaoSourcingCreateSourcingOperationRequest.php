<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.createSourcingOperation-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingCreateSourcingOperationParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingCreateSourcingOperationRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.createSourcingOperation';
    }

    public ?int $buyerUserId = null;
    public ?string $itemId = null;
    public ?string $operateType = null;
    public ?string $requisitionId = null;
    public ?string $skuId = null;
    /** 下游平台的skuId | 示例: 6666 */
    public ?string $downstreamSkuId = null;
    /** 下游平台的itemId | 示例: 445566 */
    public ?string $downstreamItemId = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
