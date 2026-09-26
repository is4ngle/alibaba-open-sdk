<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:product.keywords.search-1
 * 生成自官方 SDK 参数类 ProductKeywordsSearchParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ProductKeywordsSearchRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'product.keywords.search';
    }

    /** 限定类目ID列表，从类目搜索接口获取 | 示例: ["10166"] */
    public ?array $categoryIds = null;
    /** 搜索关键词 | 示例: 衣服 */
    public ?string $keywords = null;
    /** 当前页码 | 示例: 1 */
    public ?int $pageNum = null;
    /** 分页页大小，默认20最大50 | 示例: 20 */
    public ?int $pageSize = null;
    /** 价格区间结束（单位 元） | 示例: 1 */
    public ?string $priceEnd = null;
    /** 价格区间开始（单位 元） | 示例: 5 */
    public ?string $priceStart = null;
    /** 起批量 | 示例: 1 */
    public ?int $quantityBegin = null;
    public ?string $sortOrder = null;
    public ?string $sortType = null;
    /** 过滤参数，fxBrandOffer-1688分销品牌商品黑标，hasAIMaterials-1688分销AI素材商品，严选分值等级：YX_SCORE_LEVEL_1-“分销推荐星级：5星”、YX_SCORE_LEVEL_2-“分销推荐星级：4星” | 示例: ["fxBrandOffer", "hasAIMaterials"] */
    public ?array $filter = null;

    protected function wrapKey(): ?string
    {
        return 'param';
    }
}
