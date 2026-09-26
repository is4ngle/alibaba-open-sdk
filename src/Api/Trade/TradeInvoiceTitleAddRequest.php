<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoiceTitleAdd-1
 * 生成自官方 SDK 参数类 TradeInvoiceTitleAddParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceTitleAddRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoiceTitleAdd';
    }

    /** 四级地址code | 示例: 33333333 */
    public ?string $addressCode = null;
    /** 银行账号 | 示例: 123 */
    public ?string $bankAccountId = null;
    /** 开户行 | 示例: 开户行 */
    public ?string $bankName = null;
    /** 市 | 示例: XX市 */
    public ?string $city = null;
    /** 区 | 示例: XX区 */
    public ?string $district = null;
    /** 邮箱 | 示例: xxx@xxx.xxx */
    public ?string $email = null;
    /** 详细地址 | 示例: 详细地址 */
    public ?string $fullAddress = null;
    /** 发票抬头 | 示例: 发票抬头 */
    public ?string $invoiceTitle = null;
    /** 是否设置为默认发票 | 示例: false */
    public ?bool $isDefault = null;
    /** 电话 | 示例: 137***2 */
    public ?string $mobilPhone = null;
    /** 姓名 | 示例: 姓名 */
    public ?string $name = null;
    /** 邮编 | 示例: 320001 */
    public ?string $postCode = null;
    /** 省 | 示例: XX省 */
    public ?string $province = null;
    /** 街道 | 示例: XX街道 */
    public ?string $street = null;
    /** 纳税人识别号（专票必填） | 示例: 123 */
    public ?string $taxpayerIdentify = null;
    /** 固话 | 示例: 8008 */
    public ?string $telePhone = null;
    /** 发票抬头类型：个人和社会组织都填 PERSONAL；企业填 COMPANY | 示例: PERSONAL */
    public ?string $titleType = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
