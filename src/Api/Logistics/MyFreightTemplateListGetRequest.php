<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:alibaba.logistics.myFreightTemplateList.get-1
 * 生成自官方 SDK 参数类 AlibabaLogisticsMyFreightTemplateListGetParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class MyFreightTemplateListGetRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'alibaba.logistics.myFreightTemplateList.get';
    }

    /** 模版id，用于单条查询的场景 | 示例: xxx */
    public ?int $templateId = null;
    /** 是否查询子模板 | 示例: false */
    public ?bool $querySubTemplate = null;
    /** 是否查询子模板费率 | 示例: false */
    public ?bool $queryRate = null;
}
