<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.cancel-1
 * 生成自官方 SDK 参数类 AlibabaTradeCancelParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class CancelRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.cancel';
    }

    /** 站点信息，指定调用的API是属于国际站（alibaba）还是1688网站（1688） | 示例: 1688 */
    public ?string $webSite = null;
    /** 交易id，订单号 | 示例: 123456 */
    public ?int $tradeID = null;
    /** 原因描述；buyerCancel:买家取消订单;sellerGoodsLack:卖家库存不足;other:其它 | 示例: other */
    public ?string $cancelReason = null;
    /** 备注 | 示例: 备注 */
    public ?string $remark = null;
}
