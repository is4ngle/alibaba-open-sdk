<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Product;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.product:alibaba.category.searchByKeyword-1
 * 生成自官方 SDK 参数类 AlibabaCategorySearchByKeywordParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaCategorySearchByKeywordRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.product';
    }

    public function getApiName(): string
    {
        return 'alibaba.category.searchByKeyword';
    }

    /** 叶子类目关键字 | 示例: 帽子 */
    public ?string $keyword = null;
}
