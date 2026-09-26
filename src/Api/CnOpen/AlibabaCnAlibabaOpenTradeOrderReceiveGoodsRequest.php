<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\CnOpen;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: cn.alibaba.open:alibaba.cn.alibaba.open.trade.order.receiveGoods-1
 * 生成自官方 SDK 参数类 AlibabaCnAlibabaOpenTradeOrderReceiveGoodsParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaCnAlibabaOpenTradeOrderReceiveGoodsRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'cn.alibaba.open';
    }

    public function getApiName(): string
    {
        return 'alibaba.cn.alibaba.open.trade.order.receiveGoods';
    }


}
