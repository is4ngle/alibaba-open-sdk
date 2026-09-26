<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.refund.returnGoods-1
 * 生成自官方 SDK 参数类 AlibabaTradeRefundReturnGoodsParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RefundReturnGoodsRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.refund.returnGoods';
    }

    /** 退款单号，TQ开头 | 示例: TQ36706338027991577 */
    public ?string $refundId = null;
    /** 物流公司编码，调用alibaba.logistics.OpQueryLogisticCompanyList.offline接口查询 | 示例: ZTO */
    public ?string $logisticsCompanyNo = null;
    /** 物流公司运单号，请准确填写，否则卖家有权拒绝退款 | 示例: 3110044550034338 */
    public ?string $freightBill = null;
    /** 发货说明，内容在2-200个字之间 | 示例: 发货说明 */
    public ?string $description = null;
    /** 凭证图片URLs，必须使用API alibaba.trade.uploadRefundVoucher返回的“图片域名/相对路径”，最多可上传 10 张图片 ；单张大小不超过1M；支持jpg、gif、jpeg、png、和bmp格式。 请上传凭证，以便以后续赔所需（不上传将无法理赔） | 示例: [https://cbu01.alicdn.com/img/ibank/2019/901/930/11848039109.jpg] */
    public ?array $vouchers = null;
}
