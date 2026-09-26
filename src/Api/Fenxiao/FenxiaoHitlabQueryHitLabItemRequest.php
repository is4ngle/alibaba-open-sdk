<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiaoHitlabQueryHitLabItem-1
 * 生成自官方 SDK 参数类 FenxiaoHitlabQueryHitLabItemParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class FenxiaoHitlabQueryHitLabItemRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiaoHitlabQueryHitLabItem';
    }

    /** 爆品id | 示例: HL2222333 */
    public ?string $hitLabItemId = null;
    /** 买家用户id | 示例: 1112222 */
    public ?int $userId = null;

    protected function wrapKey(): ?string
    {
        return 'queryRequest';
    }
}
