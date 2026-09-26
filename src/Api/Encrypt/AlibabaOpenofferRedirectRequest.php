<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Encrypt;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.encrypt:alibaba.openoffer.redirect-1
 * 生成自官方 SDK 参数类 AlibabaOpenofferRedirectParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class AlibabaOpenofferRedirectRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.encrypt';
    }

    public function getApiName(): string
    {
        return 'alibaba.openoffer.redirect';
    }


}
