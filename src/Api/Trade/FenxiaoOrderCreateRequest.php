<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.fenxiaoOrder.create-1
 * 生成自官方 SDK 参数类 AlibabaTradeFenxiaoOrderCreateParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoOrderCreateRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.fenxiaoOrder.create';
    }

    /** 收货地址 | 示例: {"address":"网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张三","postCode": "000000","areaText": "滨江区","townText": "","cityText": "杭州市","provinceText": "浙江省"} | 嵌套模型: AlibabaOceanOpenplatformBizTradeCommonModelBizFastAddressParam */
    public ?array $addressParam = null;
    /** 购买的商品信息 | 示例: [{"specId": "b266e0726506185beaf205cbae88530d","quantity": 5,"offerId": 554456348334},{"specId": "2ba3d63866a71fbae83909d9b4814f01","quantity": 6,"offerId": 554456348334}] */
    public ?array $cargoParamList = null;
    /** 买家留言 | 示例: 留言 */
    public ?string $message = null;
    /** 由于不同的商品支持的交易方式不同，没有一种交易方式是全局通用的，所以当前下单可使用的交易方式必须通过下单预览接口的tradeModeNameList获取。交易方式类型说明：assureTrade（交易4.0通用担保交易），alipay（大市场通用的支付宝担保交易（目前在做切流，后续会下掉）），period（普通账期交易）, assure（大买家企业采购询报价下单时需要使用的担保交易流程）, creditBuy（诚E赊），bank（银行转账），631staged（631分阶段付款），37staged（37分阶段）；此字段不传则系统默认会选取一个可用的交易方式下单，如果开通了诚E赊默认是creditBuy（诚E赊），未开通诚E赊默认使用的方式是支付宝担宝交易。 | 示例: assureTrade */
    public ?string $tradeType = null;
    /** 发票信息 | 示例: {"invoiceType":0,"cityText": "杭州市","provinceText": "浙江省","address": "网商路699号","phone": "0517-88990077","mobile": "15251667788","fullName": "张五","postCode": "000000","areaText": "滨江区","companyName": "测试公司","taxpayerIdentifier": "123455"} | 嵌套模型: AlibabaOceanOpenplatformBizTradeCommonModelBizFastInvoiceParam */
    public ?array $invoiceParam = null;
    /** 店铺优惠ID，通过“创建订单前预览数据接口”获得。为空默认使用默认优惠 | 示例: itemCoupon-5600812521_31032085284-398517001570 */
    public ?string $shopPromotionId = null;
    /** erp分销场景时传入true。会修改默认的isvbiztype为erp_buy。其他场景不用传入 | 示例: true */
    public ?bool $isvbiztypeErp = null;
    /** 拍单场景时传入true。会修改默认的isvBizTyp为isv_pd_buy | 示例: false */
    public ?bool $isvBizTypePD = null;
    /** 开放平台业务码,区分具体业务,isvtools,isv_fxgl,wangwang_push_order(推单场景) | 示例: isvtools */
    public ?string $isvBizTypeStr = null;
    /** 分销场景flow:fenxiao | 示例: fenxiao */
    public ?string $flow = null;
    /** 下游加密订单信息，用于下游平台打单使用。如果下游明文，encryptOrder传入false | 示例: {} | 嵌套模型: AlibabaTradeFenxiaoOrderCreateEncryptOutOrderInfo */
    public ?array $encryptOutOrderInfo = null;
    /** 是否价格择优下单，开启则进行内部比价，选择最优下单方式 | 示例: true */
    public ?bool $bestOption = null;
    /** 是否拆单，如果商品中有精选货源和其他商品混合的情况，是否按最优价拆单 | 示例: true */
    public ?bool $isSplitJxhy = null;
    /** 分账普通下单采购单id，交易flow为“proxy” | 示例: 4051300002 */
    public ?string $proxySettleRecordId = null;
    /** 预选的支付渠道，用作财务订单分流。订单信息查询接口返回：result.exAttributes.preSelectPayChannel ，该值是创建订单接口时传入的预选的支付渠道标记。 | 示例: alipay */
    public ?string $preSelectPayChannel = null;
    /** 外部订单号,可用于幂等。通过订单列表接口可以传入该值查询订单信息 | 示例: 988129883123 */
    public ?string $outOrderId = null;
    /** 推单申请单 | 示例: 推单业务申请单 */
    public ?string $pushOrderApplyId = null;
    /** 订单参数拓展 | 示例: {} | 嵌套模型: ComAlibabaOceanOpenplatformBizTradeParamExtendParam */
    public ?array $extendParam = null;
}
