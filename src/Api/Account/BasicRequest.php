<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Account;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.account:alibaba.account.basic-1
 * 生成自官方 SDK 参数类 AlibabaAccountBasicParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class BasicRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.account';
    }

    public function getApiName(): string
    {
        return 'alibaba.account.basic';
    }


}
