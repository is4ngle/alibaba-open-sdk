<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:alibaba.orderMemo.add-1
 * 生成自官方 SDK 参数类 AlibabaOrderMemoAddParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaOrderMemoAddRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'alibaba.orderMemo.add';
    }

    /** 订单ID | 示例: 1234567 */
    public ?int $orderId = null;
    /** 备忘信息 | 示例: 订单备忘详情 */
    public ?string $memo = null;
    /** 备忘图标，目前仅支持数字。1位红色图标，2为蓝色图标，3为绿色图标，4为黄色图标 | 示例: 2 */
    public ?string $remarkIcon = null;
}
