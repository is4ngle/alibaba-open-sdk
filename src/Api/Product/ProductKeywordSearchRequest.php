<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Product;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.product:product.keyword.search-1
 * 生成自官方 SDK 参数类 ProductKeywordSearchParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ProductKeywordSearchRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.product';
    }

    public function getApiName(): string
    {
        return 'product.keyword.search';
    }

    /** 关键词 | 示例: 帐篷 */
    public ?string $keywords = null;
    /** 限定类目ID列表 | 示例: ["10166"] */
    public ?array $categoryIds = null;
    /** 起批量 | 示例: 2 */
    public ?int $quantityBegin = null;
    /** 价格区间过滤，起始价� | 示例: 10 */
    public ?string $priceStart = null;
    /** 价格区间过滤，终止价� | 示例: 100 */
    public ?string $priceEnd = null;
    /** 过滤参数，shipIn48Hours（48小时发货），freeExchange7days（7天包换），powerMerchant（实力商家），crossPotential(跨境潜力商品)，ttpft(批发团商品)，jxhy(精选货源商品)，严选分值等级：YX_SCORE_LEVEL_1-“分销推荐星级：5星”、YX_SCORE_LEVEL_2-“分销推荐星级：4星” | 示例: ["jxhy"] */
    public ?array $filter = null;
    /** 翻页大小 | 示例: 20 */
    public ?int $pageSize = null;
    /** 当前页 | 示例: 1 */
    public ?int $pageNum = null;

    protected function wrapKey(): ?string
    {
        return 'param';
    }
}
