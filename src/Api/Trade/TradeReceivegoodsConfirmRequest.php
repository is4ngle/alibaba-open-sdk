<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.receivegoodsConfirm-1
 * 生成自官方 SDK 参数类 TradeReceivegoodsConfirmParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeReceivegoodsConfirmRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.receivegoodsConfirm';
    }

    /** 订单ID | 示例: 56623232655125698 */
    public ?int $orderId = null;
    /** 子订单ID | 示例: 562356635566365512 */
    public ?array $orderEntryIds = null;
}
