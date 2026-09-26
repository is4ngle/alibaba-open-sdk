<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:buyerOutproductRelationDelete-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoBuyerOutproductRelationDeleteParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class BuyerOutproductRelationDeleteRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'buyerOutproductRelationDelete';
    }

    /** 上游1688商品id | 示例: 135654554 */
    public ?int $offerId = null;
    /** 上游1688加密商品id | 示例: 9bUz3grRAbwRsU/P4rGTIQ== */
    public ?string $openOfferId = null;
    /** 下游店铺code | 示例: shop123 */
    public ?string $outShopCode = null;
    /** 下游店铺商品ID | 示例: item123 */
    public ?string $outItemCode = null;
    /** 下游分销渠道 | 示例: 淘宝-thyny，天猫-tm，淘特-taote，阿里巴巴C2M-c2m，京东-jingdong，拼多多-pinduoduo，微信-weixin，跨境-kuajing，快手-kuaishou，有赞-youzan，抖音-douyin，寺库-siku，美团团好货-meituan，小红书-xiaohongshu，当当-dangdang，苏宁-suning，大V店-davdian，行云-xingyun，蜜芽-miya，菠萝派商城-boluo，快团团-kuaituantuan，其他-other */
    public ?string $channel = null;
}
