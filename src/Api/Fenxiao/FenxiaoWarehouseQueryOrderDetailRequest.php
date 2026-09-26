<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.warehouse.queryOrderDetail-1
 * 生成自官方 SDK 参数类 FenxiaoWarehouseQueryOrderDetailParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoWarehouseQueryOrderDetailRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.warehouse.queryOrderDetail';
    }

    /** 云仓订单id | 示例: 1111 */
    public ?string $cloudOrderId = null;
}
