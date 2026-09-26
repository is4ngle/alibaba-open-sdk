<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.getSourcingResultList-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingGetSourcingResultListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingGetSourcingResultListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.getSourcingResultList';
    }

    public ?int $buyerUserId = null;
    public ?string $downstreamSkuId = null;
    public ?string $requisitionId = null;
    /** 主题名称 | 示例: 元旦 */
    public ?string $topicName = null;
    /** 页码数 | 示例: 1 */
    public ?int $pageNum = null;
    /** 页码大小 | 示例: 10 */
    public ?int $pageSize = null;
    /** 寻源类型 | 示例: ka_change_supplier（KA换供），new_product_on_topic（主题上新） */
    public ?string $sourcingType = null;
    /** 商品来源 | 示例: fxyx（分销严选）、gftg（官方托管）、zs（招商） */
    public ?string $itemSource = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
