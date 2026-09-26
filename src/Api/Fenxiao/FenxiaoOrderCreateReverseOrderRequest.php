<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.order.createReverseOrder-1
 * 生成自官方 SDK 参数类 FenxiaoOrderCreateReverseOrderParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoOrderCreateReverseOrderRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.order.createReverseOrder';
    }

    public ?string $appKey = null;
    public ?int $buyerId = null;
    public ?string $orderId = null;
    public ?string $outItemId = null;
    public ?string $outOrderId = null;
    public ?string $outSkuId = null;
    public ?float $outSubGmv = null;
    public ?string $outSubOrderId = null;
    public ?float $outSubQty = null;
    public ?float $reverseAmt = null;
    public ?string $reverseReason = null;
    public ?string $subOrderId = null;
    /** 发起售后时间 | 示例: 2025-02-18 08:20:10 | 嵌套模型: Date */
    public ?array $reverseTime = null;
    /** 下游平台code | 示例: 比如抖音-douyin，小红书-xiaohongshu */
    public ?string $outPlatformCode = null;
    /** 售后凭证（图片凭证） | 示例: 图片url地址（注意：别传任何字符、标点符号） */
    public ?array $reverseReasonPic = null;
    /** 售后二级原因 | 示例: 如抖店的原因标签，若下游平台不存在可不返回，若有请回传（注意：别传任何字符、标点符号） */
    public ?array $reverseReasonSec = null;
    /** 售后说明 | 示例: 下游C买提交的售后说明文字，若为空值，无需回传 */
    public ?string $reverseDesc = null;

    protected function wrapKey(): ?string
    {
        return 'createReq';
    }
}
