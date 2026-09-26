<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.payProtocolPayPreparePay-1
 * 生成自官方 SDK 参数类 AlibabaTradePayProtocolPayPreparePayParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class PayProtocolPayPreparePayRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.payProtocolPayPreparePay';
    }

    public ?string $accountType = null;
    public ?int $buyerId = null;
    public ?int $orderId = null;
    /** 嵌套模型: AlibabaOceanOpenplatformCommonCallerInfo */
    public ?array $callerInfo = null;
    public ?string $opRequestId = null;
    /** 跨境宝支付传入kjpayV2 | 示例: kjpayV2 */
    public ?string $payChannel = null;
    /** 付款总金额,单位分 | 示例: 123 */
    public ?int $payAmount = null;

    protected function wrapKey(): ?string
    {
        return 'tradeWithholdPreparePayParam';
    }
}
