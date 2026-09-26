<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.trade.createFenxiaoOrder.preview-1
 * 生成自官方 SDK 参数类 AlibabaTradeCreateFenxiaoOrderPreviewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaTradeCreateFenxiaoOrderPreviewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.createFenxiaoOrder.preview';
    }

    /** 收货地址信息 | 示例: {"address":"网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张三","postCode": "000000","areaText": "滨江区","townText": "","cityText": "杭州市","provinceText": "浙江省"} | 嵌套模型: AlibabaTradeFenXiaoOrderPreviewAddress */
    public ?array $addressParam = null;
    /** 商品信息 | 示例: [{"specId": "b266e0726506185beaf205cbae88530d","quantity": 5,"offerId": 554456348334},{"specId": "2ba3d63866a71fbae83909d9b4814f01","quantity": 6,"offerId": 554456348334}] */
    public ?array $cargoParamList = null;
    /** 发票信息 | 示例: {"invoiceType":0,"cityText": "杭州市","provinceText": "浙江省","address": "网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张五","postCode": "000000","areaText": "滨江区","companyName": "测试公司","taxpayerIdentifier": "123455"} | 嵌套模型: FenXiaoOrderInvoiceParam */
    public ?array $invoiceParam = null;
    /** general（创建大市场订单），fenxiao（创建分销订单）。fenxiao流程将校验分销关系。默认会做比价，返回最优下单策略 | 示例: general */
    public ?string $flow = null;
    /** 是否拆单，如果商品中有精选货源和其他商品混合的情况，是否按最优价拆单 | 示例: true */
    public ?bool $isSplitJxhy = null;
    /** 分销预览下游加密信息 | 示例: {} | 嵌套模型: AlibabaTradeFenxiaoOrderPreviewEncryptOutOrderInfo */
    public ?array $encryptOutOrderInfo = null;
    /** 分账普通下单采购单id，交易flow为“proxy” | 示例: 4051300002 */
    public ?string $proxySettleRecordId = null;
    /** 是否比价，最优化策略预览 | 示例: true */
    public ?string $bestOption = null;
}
