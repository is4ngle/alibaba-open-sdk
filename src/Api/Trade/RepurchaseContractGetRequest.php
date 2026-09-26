<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:repurchaseContract.get-1
 * 生成自官方 SDK 参数类 RepurchaseContractGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RepurchaseContractGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'repurchaseContract.get';
    }

    /** 商品id列表 | 示例: [867442475017] */
    public ?array $offerIds = null;

    protected function wrapKey(): ?string
    {
        return 'param';
    }
}
