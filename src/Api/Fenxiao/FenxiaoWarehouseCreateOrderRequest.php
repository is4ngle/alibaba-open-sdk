<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.warehouse.createOrder-1
 * 生成自官方 SDK 参数类 FenxiaoWarehouseCreateOrderParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoWarehouseCreateOrderRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.warehouse.createOrder';
    }

    /** 1688售后单id，orderType为cloudWarehouseReturn时必填 | 示例: 111 */
    public ?string $ali1688RefundId = null;
    /** 云仓code | 示例: SD233 */
    public ?string $cloudWarehouseCode = null;
    /** 子单列表 | 示例: {} */
    public ?array $orderEntryList = null;
    /** 订单类型 | 示例: cloudWarehouseReturn：1688退款单的云仓退货订单；cloudWarehouseReturnOut：非1688退款单的云仓退货订单 */
    public ?string $orderType = null;
    /** 下游订单号 | 示例: 111 */
    public ?string $outOrderId = null;
    /** 下游售后单号 | 示例: 111 */
    public ?string $outRefundId = null;
    /** 下游退货地址 | 示例: {} | 嵌套模型: AlibabaCbuLinkorderModelLinkOrderReceiverInfo */
    public ?array $outReturnAddressInfo = null;
    /** 下游退货物流公司编码 | 示例: SGHKY */
    public ?string $outReturnLogisticsCompanyCode = null;
    /** 下游退货物流公司名称 | 示例: xxx */
    public ?string $outReturnLogisticsCompanyName = null;
    /** 下游退货物流运单号 | 示例: 12dde234 */
    public ?string $outReturnLogisticsNumber = null;
    /** 1688订单id，orderType为cloudWarehouseReturn时必填 | 示例: 222222 */
    public ?string $ali1688OrderId = null;
    /** 非1688退款单的云仓退货订单唯一标识，orderType为cloudWarehouseReturnOut时必填，最长32位 | 示例: appkey+渠道code+唯一id */
    public ?string $requestId = null;
    /** 商家收货地址，即官方仓出仓地址，，orderType为cloudWarehouseReturnOut时可填 | 示例: {} | 嵌套模型: AlibabaCbuLinkorderModelLinkOrderReceiverInfo */
    public ?array $receiverInfo = null;
    /** 加密类型 1=明文 2=OAID 3=密文 默认为1 | 示例: 2 */
    public ?string $encryptType = null;
    /** 商家收货地址密文地址 | 示例: {} | 嵌套模型: ComAlibabaCbuLinkorderModelEncryptOutOrderInfo */
    public ?array $encryptOutOrderInfo = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
