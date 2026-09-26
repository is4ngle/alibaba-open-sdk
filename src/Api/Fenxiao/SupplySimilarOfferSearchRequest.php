<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:supply.similarOffer.search-1
 * 生成自官方 SDK 参数类 SupplySimilarOfferSearchParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class SupplySimilarOfferSearchRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'supply.similarOffer.search';
    }

    /** 待查询图片的Base64，图片大小不超过3M | 示例: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATsAAACgCAMAAABE1DvBAAAAflBMVEX////sM1j09PTsL1X/+vv5xs/sLVTrJE7rH0vrJU/rKFHwa4P+9/n5xM7/+vz+7vHrGEj0lab+8/bvW3b84OX60djyepD4tcH72N7uRmf4usX6zNTwYHvwZoDwbYbL" */
    public ?string $imgBase64 = null;
    /** 图片地址 | 示例: https://www.gcdn01.com/xsf.jpg */
    public ?string $imgUrl = null;
    /** 关键词utf8 | 示例: "连衣裙" */
    public ?string $keywords = null;
    /** 下游平台(thyny -> 淘宝     douyin -> 抖音     kuaishou -> 快手     pinduoduo -> 拼多多     xiaohongshu -> 小红书     jingdong -> 京东) | 示例: thyny */
    public ?string $platform = null;
    /** 下游商品Id | 示例: 123456789 */
    public ?int $platformItemId = null;
    /** 1688原供商品Id | 示例: 123456789 */
    public ?int $originalItemId = null;
    /** 场景- 1("同款换供")、 2("搭配推荐")、3("同款换供&搭配推荐") | 示例: 1 */
    public ?int $scene = null;
}
