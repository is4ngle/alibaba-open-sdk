<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Industrial;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.industrial:qycg.selfOpItem.getList-1
 * 生成自官方 SDK 参数类 QycgSelfOpItemGetListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class QycgSelfOpItemGetListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.industrial';
    }

    public function getApiName(): string
    {
        return 'qycg.selfOpItem.getList';
    }

    /** 类目信息 | 示例: 96 */
    public ?int $cateId = null;
    /** 是否包邮 | 示例: true */
    public ?bool $isFreeShipping = null;
    /** 起批量 | 示例: 1 */
    public ?int $minOrderQuantity = null;
    /** 分页 | 示例: 1 */
    public ?int $pageNo = null;
    /** 单页数量 | 示例: 10 */
    public ?int $pageSize = null;

    protected function wrapKey(): ?string
    {
        return 'param';
    }
}
