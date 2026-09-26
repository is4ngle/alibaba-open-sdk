<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.fenxiao.chosenOfferlist.removeall-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoChosenOfferlistRemoveallParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ChosenOfferlistRemoveallRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.fenxiao.chosenOfferlist.removeall';
    }

    /** 唯一Key | 示例: UJL56SFHB23584 */
    public ?string $uniqueKey = null;
}
