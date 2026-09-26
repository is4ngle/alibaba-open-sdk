<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.trade.uploadRefundVoucher-1
 * 生成自官方 SDK 参数类 AlibabaTradeUploadRefundVoucherParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class UploadRefundVoucherRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.trade.uploadRefundVoucher';
    }

    /** 凭证图片数据。小于1M，jpg格式。 */
    public ?array $imageData = null;
}
