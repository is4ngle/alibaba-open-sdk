<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:tradeEncryptOutOrderInfoModify-1
 * 生成自官方 SDK 参数类 TradeEncryptOutOrderInfoModifyParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class TradeEncryptOutOrderInfoModifyRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'tradeEncryptOutOrderInfoModify';
    }

    /** 1688订单ID | 示例: 2325656612313 */
    public ?int $orderId = null;
    /** 外部加密订单信息 | 示例: {} | 嵌套模型: ComAlibabaOceanOpenplatformBizTradeParamEncryptOutOrderInfo */
    public ?array $encryptOutOrderInfo = null;
}
