<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.refund.buyerQueryOrderRefundList-1
 * 生成自官方 SDK 参数类 AlibabaTradeRefundBuyerQueryOrderRefundListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RefundBuyerQueryOrderRefundListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.refund.buyerQueryOrderRefundList';
    }

    /** 订单Id | 示例: 179087886005498520 */
    public ?int $orderId = null;
    /** 退款申请时间（起始） | 示例: 20170926114526000+0800 | 嵌套模型: Date */
    public ?array $applyStartTime = null;
    /** 退款申请时间（截止） | 示例: 20220926114526000+0800 | 嵌套模型: Date */
    public ?array $applyEndTime = null;
    /** 退款状态列表 | 示例: 等待卖家同意 waitselleragree;退款成功 refundsuccess;退款关闭 refundclose;待买家修改 waitbuyermodify;等待买家退货 waitbuyersend;等待卖家确认收货 waitsellerreceive */
    public ?array $refundStatusSet = null;
    /** 卖家memberId | 示例: b2b-1623492085 */
    public ?string $sellerMemberId = null;
    /** 当前页码 | 示例: 0 */
    public ?int $currentPageNum = null;
    /** 每页条数 | 示例: 20 */
    public ?int $pageSize = null;
    /** 退货物流单号（传此字段查询时，需同时传入sellerMemberId） | 示例: 3101***159271 */
    public ?string $logisticsNo = null;
    /** 退款修改时间(起始) | 示例: 20170926114526000+0800 | 嵌套模型: Date */
    public ?array $modifyStartTime = null;
    /** 退款修改时间(截止) | 示例: 20220926114526000+0800 | 嵌套模型: Date */
    public ?array $modifyEndTime = null;
    /** 1:售中退款，2:售后退款；0:所有退款单 | 示例: 1 */
    public ?int $dipsuteType = null;
}
