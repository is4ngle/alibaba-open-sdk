<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.supply.addMonitorProduct-1
 * 生成自官方 SDK 参数类 FenxiaoSupplyAddMonitorProductParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSupplyAddMonitorProductRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.supply.addMonitorProduct';
    }

    /** 商品id | 示例: 1234 */
    public ?int $offerId = null;
    /** 商品skuIds | 示例: - */
    public ?array $skuIds = null;

    protected function wrapKey(): ?string
    {
        return 'addRequest';
    }
}
