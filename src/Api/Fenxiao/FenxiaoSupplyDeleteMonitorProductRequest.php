<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.supply.deleteMonitorProduct-1
 * 生成自官方 SDK 参数类 FenxiaoSupplyDeleteMonitorProductParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSupplyDeleteMonitorProductRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.supply.deleteMonitorProduct';
    }

    /** 商品id | 示例: 123 */
    public ?int $offerId = null;
    /** skuIds | 示例: - */
    public ?array $skuIds = null;

    protected function wrapKey(): ?string
    {
        return 'deleteRequest';
    }
}
