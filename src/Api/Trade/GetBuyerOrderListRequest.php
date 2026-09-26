<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.getBuyerOrderList-1
 * 生成自官方 SDK 参数类 AlibabaTradeGetBuyerOrderListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class GetBuyerOrderListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.getBuyerOrderList';
    }

    /** 业务类型，支持： "cn"(普通订单类型), "ws"(大额批发订单类型), "yp"(普通拿样订单类型), "yf"(一分钱拿样订单类型), "fs"(倒批(限时折扣)订单类型), "cz"(加工定制订单类型), "ag"(协议采购订单类型), "hp"(伙拼订单类型), "gc"(国采订单类型), "supply"(供销订单类型), "nyg"(nyg订单类型), "factory"(淘工厂订单类型), "quick"(快订下单), "xiangpin"(享拼订单), "nest"(采购商城-鸟巢), "f2f"(当面付), "cyfw"(存样服务), "sp"(代销订单标记), "wg"(微供订单), "factorysamp"(淘工厂打样订单), "factorybig"(淘工厂大货订单) | 示例: ["cn","ws"] */
    public ?array $bizTypes = null;
    /** 下单结束时间 | 示例: 20180802211113000+0800 | 嵌套模型: Date */
    public ?array $createEndTime = null;
    /** 下单开始时间 | 示例: 20180102211113000+0800 | 嵌套模型: Date */
    public ?array $createStartTime = null;
    /** 是否查询历史订单表,默认查询当前表，即默认值为false | 示例: false */
    public ?bool $isHis = null;
    /** 查询修改时间结束 | 示例: 20180802211113000+0800 | 嵌套模型: Date */
    public ?array $modifyEndTime = null;
    /** 查询修改时间开始 | 示例: 20180102211113000+0800 | 嵌套模型: Date */
    public ?array $modifyStartTime = null;
    /** 订单状态，值有 success, cancel(交易取消，违约金等交割完毕), waitbuyerpay(等待卖家付款)， waitsellersend(等待卖家发货), waitbuyerreceive(等待买家收货 ) | 示例: success */
    public ?string $orderStatus = null;
    /** 查询分页页码，从1开始 | 示例: 1 */
    public ?int $page = null;
    /** 查询的每页的数量 | 示例: 20 */
    public ?int $pageSize = null;
    /** 退款状态，支持： "waitselleragree"(等待卖家同意), "refundsuccess"(退款成功), "refundclose"(退款关闭), "waitbuyermodify"(待买家修改), "waitbuyersend"(等待买家退货), "waitsellerreceive"(等待卖家确认收货) | 示例: refundsuccess */
    public ?string $refundStatus = null;
    /** 卖家memberId | 示例: b2b-1624961198 */
    public ?string $sellerMemberId = null;
    /** 卖家loginId | 示例: alitestforisv02 */
    public ?string $sellerLoginId = null;
    /** 卖家评价状态 (4:已评价,5:未评价,6;不需要评价) | 示例: 6 */
    public ?int $sellerRateStatus = null;
    /** 交易类型:；担保交易(1),；预存款交易(2),；ETC境外收单交易(3),；即时到帐交易(4),；保障金安全交易(5),；统一交易流程(6),；分阶段交易(7),；货到付款交易(8),；信用凭证支付交易(9),；账期支付交易(10),；1688交易4.0，新分阶段交易(50060),；当面付的交易流程(50070),；服务类的交易流程(50080) | 示例: 50060 */
    public ?string $tradeType = null;
    /** 商品名称 | 示例: 测试商品 */
    public ?string $productName = null;
    /** 是否需要查询买家的详细地址信息和电话 | 示例: false */
    public ?bool $needBuyerAddressAndPhone = null;
    /** 是否需要查询备注信息 | 示例: false */
    public ?bool $needMemoInfo = null;
    /** 外部订单号，可用于控制幂等 | 示例: 90187872898371 */
    public ?string $outOrderId = null;
    /** 需要查询开票设置 | 示例: true */
    public ?bool $needInvoicingSetting = null;
    /** 查询多个订单id | 示例: [90187872898371,90187872898372] */
    public ?array $orderIds = null;
}
