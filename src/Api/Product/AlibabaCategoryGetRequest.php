<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Product;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.product:alibaba.category.get-1
 * 生成自官方 SDK 参数类 AlibabaCategoryGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaCategoryGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.product';
    }

    public function getApiName(): string
    {
        return 'alibaba.category.get';
    }

    /** 类目id,必须大于等于0， 如果为0，则查询所有一级类目 | 示例: 1031910 */
    public ?int $categoryID = null;
}
