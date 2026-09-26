<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:dkey.get-1
 * 生成自官方 SDK 参数类 DkeyGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class DkeyGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'dkey.get';
    }

    /** offerId列表 | 示例: [1233465454554,1223354545] */
    public ?array $offerIds = null;
    /** 入口类型，不传默认1688 | 示例: entrance_pft */
    public ?string $entranceCode = null;
}
