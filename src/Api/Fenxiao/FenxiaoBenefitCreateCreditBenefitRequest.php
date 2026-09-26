<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiaoBenefitCreateCreditBenefit-1
 * 生成自官方 SDK 参数类 FenxiaoBenefitCreateCreditBenefitParam（bin/generate.php，勿手改，重跑覆盖）
 * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）
 */
final class FenxiaoBenefitCreateCreditBenefitRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiaoBenefitCreateCreditBenefit';
    }

    /** 权益code | 示例: 比如：XCHF */
    public ?string $benefitCode = null;
    public ?int $userId = null;
    /** 先采后付分销版开通状态 | 示例: 1:先采后付分销版；0:先采后付标准版。首次开通时，只有传1生效；开通先采后付后，可根据传的值在分销版和标准版之间切换。不传默认为1 */
    public ?int $openStatus = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
