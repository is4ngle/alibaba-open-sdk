<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:product.distributeCnt.put-1
 * 生成自官方 SDK 参数类 ProductDistributeCntPutParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ProductDistributeCntPutRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'product.distributeCnt.put';
    }

    /** 铺货次数 | 示例: 0 */
    public ?int $count = null;
}
