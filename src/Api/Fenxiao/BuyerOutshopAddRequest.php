<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.fenxiao.buyer.outshop.add-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoBuyerOutshopAddParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class BuyerOutshopAddRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.fenxiao.buyer.outshop.add';
    }

    /** 下游分销店铺编号 | 示例: 345677，举例：淘宝平台，传用户授权工具的下游user id（注意：别传任何字符、标点符号） */
    public ?string $outShopCode = null;
    /** 下游渠道代码 | 示例: 淘宝-thyny，天猫-tm，淘特-taote，阿里巴巴C2M-c2m，京东-jingdong，拼多多-pinduoduo，微信-weixin，跨境-kuajing，快手-kuaishou，有赞-youzan，抖音-douyin，寺库-siku，美团团好货-meituan，小红书-xiaohongshu，当当-dangdang，苏宁-suning，大V店-davdian，行云-xingyun，蜜芽-miya，菠萝派商城-boluo，快团团-kuaituantuan，其他-other */
    public ?string $channel = null;
    /** 下游渠道店铺名称 | 示例: 举例：淘宝平台，传“超级工厂店”（即店铺名称，注意：别传任何字符、标点符号） */
    public ?string $shopName = null;
    /** 下游店铺的头像base64编码,请保证大小在2M内 | 示例: SFFGGHGJJJJHJJGFFGG */
    public ?string $avatar = null;
    /** 必传，暂不强制校验。下游appkey可铺货的开始时间（毫秒字符串） | 示例: - */
    public ?int $authStartTime = null;
    /** 必传，暂不强制校验。下游appkey 可铺货的截止时间时间（毫秒字符串） | 示例: - */
    public ?int $authEndTime = null;
    /** 当识别到用户为1个或多个1688采购账号，请回传用户的公司名称可自定义（例如：1688采购ID 或 1688关联认证公司 或 自定义名称），注意：信息要求严肃性 | 示例: - */
    public ?string $outShopCompany = null;
}
