<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.createRefund-1
 * 生成自官方 SDK 参数类 AlibabaTradeCreateRefundParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class CreateRefundRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.createRefund';
    }

    /** 主订单 */
    public ?int $orderId = null;
    /** 子订单 */
    public ?array $orderEntryIds = null;
    /** 退款/退款退货。只有已收到货，才可以选择退款退货。 | 示例: 退款:"refund"; 退款退货:"returnRefund" */
    public ?string $disputeRequest = null;
    /** 退款金额（单位：分）。不大于实际付款金额；等待卖家发货时，必须为商品的实际付款金额。 */
    public ?int $applyPayment = null;
    /** 退运费金额（单位：分）。 */
    public ?int $applyCarriage = null;
    /** 退款原因id（从API getRefundReasonList获取） */
    public ?int $applyReasonId = null;
    /** 退款申请理由，2-150字 */
    public ?string $description = null;
    /** 货物状态 | 示例: 售中等待卖家发货:"refundWaitSellerSend"; 售中等待买家收货:"refundWaitBuyerReceive"; 售中已收货（未确认完成交易）:"refundBuyerReceived" 售后未收货:"aftersaleBuyerNotReceived"; 售后已收到货:"aftersaleBuyerReceived" */
    public ?string $goodsStatus = null;
    /** 凭证图片URLs。1-5张，必须使用API uploadRefundVoucher返回的“图片域名/相对路径” | 示例: [https://cbu01.alicdn.com/img/ibank/2019/901/930/11848039109.jpg] */
    public ?array $vouchers = null;
    /** 子订单退款数量。仅在售中买家已收货（退款退货）时，可指定退货数量；默认，全部退货。 | 示例: [{"id":586683458996743215,"count":1}] */
    public ?array $orderEntryCountList = null;
    /** 是否定制退货运费 | 示例: true：订单退款运费按照isv回传为准，不做优化；false（默认）：订单退款金额按照平台规则为准，需要做优化； */
    public ?bool $customRefund = null;
    /** 退款说明，用于接收下游退款单的实际描述 | 示例: 克重不对，偷工减料了 */
    public ?string $refundRemark = null;
}
