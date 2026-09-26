<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.createOrder.preview-1
 * 生成自官方 SDK 参数类 AlibabaCreateOrderPreviewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaCreateOrderPreviewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.createOrder.preview';
    }

    /** 收货地址信息 | 示例: {"address":"网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张三","postCode": "000000","areaText": "滨江区","townText": "","cityText": "杭州市","provinceText": "浙江省"} | 嵌套模型: AlibabaTradeFastAddress */
    public ?array $addressParam = null;
    /** 商品信息 | 示例: [{"specId": "b266e0726506185beaf205cbae88530d","quantity": 5,"offerId": 554456348334},{"specId": "2ba3d63866a71fbae83909d9b4814f01","quantity": 6,"offerId": 554456348334}] */
    public ?array $cargoParamList = null;
    /** 发票信息 | 示例: {"invoiceType":0,"cityText": "杭州市","provinceText": "浙江省","address": "网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张五","postCode": "000000","areaText": "滨江区","companyName": "测试公司","taxpayerIdentifier": "123455"} | 嵌套模型: AlibabaTradeFastInvoice */
    public ?array $invoiceParam = null;
    /** general（创建大市场订单），fenxiao（创建分销订单）,paired(天天特卖),repurchase(复购合约下单),saleproxy流程将校验分销关系,boutiquefenxiao(精选货源分销价下单，采购量1个使用包邮)， boutiquepifa(精选货源批发价下单，采购量大于2使用), flow如果为空的情况，会比价择优预览，并返回最优下单方式flow。 复购合约下单不在比价范围内。所有的下单flow渠道，可能导致价格和买保服务差异。 | 示例: general */
    public ?string $flow = null;
    /** 批发团instanceId,从alibaba.pifatuan.product.list获取 | 示例: 4063139_1662080400000 */
    public ?string $instanceId = null;
    /** 下游加密订单信息，用于下游打单使用 | 示例: {} | 嵌套模型: AlibabaTradeFastCreateOrderEncryptOutOrderInfo */
    public ?array $encryptOutOrderInfo = null;
    /** 分账普通下单采购单id，交易flow为“proxy” | 示例: 4051300002 */
    public ?string $proxySettleRecordId = null;
    /** 库存模式，jit（jit模式）或 cang（仓发模式）,目前只提供给AE使用 | 示例: jit */
    public ?string $inventoryMode = null;
    /** 外部订单号 | 示例: 988129883123 */
    public ?string $outOrderId = null;
    /** 上门揽收,目前AE供货可用，其他场景暂不开通 | 示例: y或n,默认为n */
    public ?string $pickupService = null;
    /** 用户选择的官方物流跨境解决方案sourceId | 示例: GLOBAL_CAINIAO_VN_TRANSIT_LAND */
    public ?string $crossBorderLogisticsSolutionId = null;
    /** 是否使用跨境物流解决方案预览，默认为false，当海外地址时，参数不生效。当为港澳台地址时，参数生效 | 示例: true */
    public ?bool $useBorderLogisticsSolution = null;
    /** 开放平台业务码 | 示例: cross */
    public ?string $isvBizType = null;
}
