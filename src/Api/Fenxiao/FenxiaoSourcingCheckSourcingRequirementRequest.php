<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Fenxiao;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.fenxiao:fenxiao.sourcing.checkSourcingRequirement-1
 * 生成自官方 SDK 参数类 FenxiaoSourcingCheckSourcingRequirementParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class FenxiaoSourcingCheckSourcingRequirementRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.fenxiao';
    }

    public function getApiName(): string
    {
        return 'fenxiao.sourcing.checkSourcingRequirement';
    }

    public ?array $categoryIds = null;
    public ?int $userId = null;
    /** 主题名称 | 示例: 年货节 */
    public ?string $topicName = null;
    /** 一级类目id | 示例: 比如：67 */
    public ?string $categoryId = null;
    /** 需求描述 | 示例: 详细描述 */
    public ?string $requirementSpec = null;
    /** 过期时间 | 示例: 过期时间 | 嵌套模型: Date */
    public ?array $expireTime = null;

    protected function wrapKey(): ?string
    {
        return 'request';
    }
}
