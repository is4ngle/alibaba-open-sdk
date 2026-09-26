<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.supply.queryMonitorProductList-1
 * 生成自官方 SDK 参数类 FenxiaoSupplyQueryMonitorProductListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSupplyQueryMonitorProductListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.supply.queryMonitorProductList';
    }

    /** isv的appKey | 示例: 123 */
    public ?string $appKey = null;
    /** 买家用户id | 示例: 3456 */
    public ?int $buyerUserId = null;
    /** 商品id | 示例: 11111 */
    public ?int $offerId = null;
    /** 分页页数 | 示例: 1 */
    public ?int $pageNum = null;
    /** 分页大小 | 示例: 10 */
    public ?int $pageSize = null;

    protected function wrapKey(): ?string
    {
        return 'queryRequest';
    }
}
