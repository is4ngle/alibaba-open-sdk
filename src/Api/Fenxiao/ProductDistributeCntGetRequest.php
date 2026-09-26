<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:product.distributeCnt.get-1
 * 生成自官方 SDK 参数类 ProductDistributeCntGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ProductDistributeCntGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'product.distributeCnt.get';
    }


}
