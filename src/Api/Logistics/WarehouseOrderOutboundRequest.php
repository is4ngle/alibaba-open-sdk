<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:warehouse.order.outbound-1
 * 生成自官方 SDK 参数类 WarehouseOrderOutboundParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class WarehouseOrderOutboundRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'warehouse.order.outbound';
    }

    /** 入仓运单号 | 示例: SFXXXXX */
    public ?string $mailNo = null;
    /** 出地址信息 | 示例: {} | 嵌套模型: AlibabaSharedWarehouseDtoPackageDTO */
    public ?array $outBoundPackage = null;

    protected function wrapKey(): ?string
    {
        return 'outBoundRequest';
    }
}
