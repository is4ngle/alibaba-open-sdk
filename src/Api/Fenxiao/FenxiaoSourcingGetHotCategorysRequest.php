<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.getHotCategorys-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingGetHotCategorysParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingGetHotCategorysRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.getHotCategorys';
    }

    /** 寻源类型 | 示例: 比如：ka_change_supplier */
    public ?string $sourcingType = null;
}
