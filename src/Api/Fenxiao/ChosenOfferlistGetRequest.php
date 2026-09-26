<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:alibaba.fenxiao.chosenOfferlist.get-1
 * 生成自官方 SDK 参数类 AlibabaFenxiaoChosenOfferlistGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class ChosenOfferlistGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'alibaba.fenxiao.chosenOfferlist.get';
    }

    /** 唯一key� | 示例: 45SKT9J68AD098DFKsiS */
    public ?string $uniqueKey = null;
}
