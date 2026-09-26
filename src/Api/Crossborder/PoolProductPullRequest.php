<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Crossborder;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao.crossborder:pool.product.pull-1
 * 生成自官方 SDK 参数类 PoolProductPullParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class PoolProductPullRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao.crossborder';
    }

    public function getApiName(): string
    {
        return 'pool.product.pull';
    }

    /** 品池id（业务定制且有权限控制，从对接的业务获取，随便传会报错，寻源通代采建议走词搜接口） | 示例: 111 */
    public ?int $offerPoolId = null;
    /** 类目ID | 示例: 11 */
    public ?int $cateId = null;
    /** 查询任务ID，假如货盘有10000商品，每页1000个查询10次将10000商品查走，这10次都需要传同一个taskId，机构需要在分页查询的时候固定一个taskId留存下来，然后每次分页都传同一个taskId来查该接口 | 示例: 1 */
    public ?string $taskId = null;
    /** 语言 | 示例: en */
    public ?string $language = null;
    /** 页码 | 示例: 1 */
    public ?int $pageNo = null;
    /** 每页数量 | 示例: 10 */
    public ?int $pageSize = null;
    public ?string $appKey = null;
    /** 最近1个月销售额排序 | 示例: ACE/DESC */
    public ?string $order1m = null;
    /** 最近1个月买家数排序 | 示例: ACE/DESC */
    public ?string $buyer1m = null;
    /** 排序字段 | 示例: order1m/buyer1m（order1m：最近1个月销售额排序；buyer1m：最近1个月买家数） */
    public ?string $sortField = null;
    /** 排序规则 | 示例: ASC/DESC */
    public ?string $sortType = null;

    protected function wrapKey(): ?string
    {
        return 'offerPoolQueryParam';
    }
}
