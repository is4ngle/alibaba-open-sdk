<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:buyerOutproductRelationAdd-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoBuyerOutproductRelationAddParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class BuyerOutproductRelationAddRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'buyerOutproductRelationAdd';
    }

    /** 下游分销渠道 | 示例: 淘宝-thyny，天猫-tm，淘特-taote，阿里巴巴C2M-c2m，京东-jingdong，拼多多-pinduoduo，微信-weixin，跨境-kuajing，快手-kuaishou，有赞-youzan，抖音-douyin，寺库-siku，美团团好货-meituan，小红书-xiaohongshu，当当-dangdang，苏宁-suning，大V店-davdian，行云-xingyun，蜜芽-miya，菠萝派商城-boluo，快团团-kuaituantuan，其他-other */
    public ?string $channel = null;
    /** 上游1688商品id | 示例: 135654554 */
    public ?int $offerId = null;
    /** 上游1688商品加密id | 示例: Wcv2w970KoL1BCpJGQp3vwKvcBThOPlpHnUtkK3T0n4= */
    public ?string $openOfferId = null;
    /** 下游外部商品码 | 示例: item123 */
    public ?string $outItemCode = null;
    /** 下游店铺code，如果是淘宝平台，传用户授权工具的下游user id | 示例: shop123 */
    public ?string $outShopCode = null;
    /** 铺货方式 | 示例: 用户手动-manual ，自动-hotAuto */
    public ?string $distributeType = null;
    /** sku信息列表 | 示例: {} */
    public ?array $skuList = null;
    /** 爆品id | 示例: 1 */
    public ?string $hitLabId = null;
    /** 使用AI素材详情字段,取值可能为：cpv, title, picture | 示例: ["cpv"] */
    public ?array $aiMaterialDetailFields = null;
}
