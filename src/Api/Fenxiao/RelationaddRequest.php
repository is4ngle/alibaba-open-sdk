<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.fenxiao.relationadd-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoRelationaddParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class RelationaddRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.fenxiao.relationadd';
    }

    /** 商品id | 示例: 98129931 */
    public ?int $offerId = null;
}
