<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Logistics;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.logistics:alibaba.logistics.op.queryLogisticCompanyList-1
 * 生成自官方 SDK 参数类 AlibabaLogisticsOpQueryLogisticCompanyListParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class OpQueryLogisticCompanyListRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.logistics';
    }

    public function getApiName(): string
    {
        return 'alibaba.logistics.op.queryLogisticCompanyList';
    }


}
