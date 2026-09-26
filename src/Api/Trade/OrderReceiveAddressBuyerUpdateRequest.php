<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:orderReceiveAddressBuyerUpdate-1
 * 生成自官方 SDK 参数类 OrderReceiveAddressBuyerUpdateParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class OrderReceiveAddressBuyerUpdateRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'orderReceiveAddressBuyerUpdate';
    }

    public ?int $orderId = null;
    public ?int $userId = null;
    /** 嵌套模型: AlibabaOceanOpenplatformBizTradeParamAddressParam */
    public ?array $receiveAddress = null;

    protected function wrapKey(): ?string
    {
        return 'param';
    }
}
