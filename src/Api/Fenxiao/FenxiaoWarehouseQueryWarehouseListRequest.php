<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.warehouse.queryWarehouseList-1
 * 生成自官方 SDK 参数类 FenxiaoWarehouseQueryWarehouseListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoWarehouseQueryWarehouseListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.warehouse.queryWarehouseList';
    }

    /** 分页页数 | 示例: 1 */
    public ?int $pageNum = null;
    /** 分页大小 | 示例: 10 */
    public ?int $pageSize = null;
    /** 是否签约过的云仓 | 示例: true 查询签约过的云仓列表，false代表查询全部云仓列表 */
    public ?bool $isSign = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
