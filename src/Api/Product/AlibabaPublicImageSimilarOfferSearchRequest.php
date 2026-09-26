<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Product;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.product:alibaba.public.image.similarOffer.search-1
 * 生成自官方 SDK 参数类 AlibabaPublicImageSimilarOfferSearchParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaPublicImageSimilarOfferSearchRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.product';
    }

    public function getApiName(): string
    {
        return 'alibaba.public.image.similarOffer.search';
    }

    /** 待查询图片的Base64，图片大小不超过3M | 示例: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATsAAACgCAMAAABE1DvBAAAAflBMVEX////sM1j09PTsL1X/+vv5xs/sLVTrJE7rH0vrJU/rKFHwa4P+9/n5xM7/+vz+7vHrGEj0lab+8/bvW3b84OX60djyepD4tcH72N7uRmf4usX6zNTwYHvwZoDwbYbL" */
    public ?string $imgBase64 = null;
    /** 图片地址 | 示例: https://www.gcdn01.com/xsf.jpg */
    public ?string $imgUrl = null;
    /** 图搜关键词utf8 | 示例: "连衣裙" */
    public ?string $imageKeywords = null;
    /** 图搜过滤项，YX_SCORE_LEVEL_1-“分销推荐星级：5星”；YX_SCORE_LEVEL_2-“分销推荐星级：4星” | 示例: 参考接口文档，["YX_SCORE_LEVEL_1"] */
    public ?array $filter = null;
    /** 价格区间开始 | 示例: 10 */
    public ?string $priceStart = null;
    /** 价格区间结束 | 示例: 100 */
    public ?string $priceEnd = null;
}
