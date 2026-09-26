<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api\Trade;

use Is4ngle\AlibabaOpen\Request\AbstractRequest;

/**
 * API: com.alibaba.trade:trade.invoiceApplyGetPageListBuyerView-1
 * 生成自官方 SDK 参数类 TradeInvoiceApplyGetPageListBuyerViewParam（bin/generate.php，勿手改，重跑覆盖）
 */
final class TradeInvoiceApplyGetPageListBuyerViewRequest extends AbstractRequest
{
    public function getNamespace(): string
    {
        return 'com.alibaba.trade';
    }

    public function getApiName(): string
    {
        return 'trade.invoiceApplyGetPageListBuyerView';
    }

    /** 发票状态：ISSUING(1,"开票中"),ISSUED(2,"已开票"),VERIFYING(5,"验票中"),VERIFY_FAILED(6,"验票失败"),RETURNING(10,"退票中"),RETURNED(11,"已退票"),INVALIDING(20,"作废中"),DEPRECATED(21,"已作废"),RED_ISSUING(30,"冲红中"),RED_PART_ISSUED(31,"部分冲红"),RED_ALL_ISSUED(32,"全部冲红"),FAILED(40,"开票失败"),CLOSED(50,"关闭"),; | 示例: ISSUING */
    public ?array $bizStatusList = null;
    /** 模糊发票抬头 | 示例: 模糊发票抬头 */
    public ?string $fuzzyInvoiceTitle = null;
    /** 是否红票 | 示例: false */
    public ?bool $isRedInvoice = null;
    /** 交易单id | 示例: 123 */
    public ?string $orderId = null;
    /** 发票记录的唯一Id(查询申请记录时使用)；通常是交易单id，但是红票会变 | 示例: 123 */
    public ?string $outBizId = null;
    /** 当前页，能小于1 | 示例: 1 */
    public ?int $page = null;
    /** 分页大小，不能大于100，不能小于1 | 示例: 10 */
    public ?int $pageSize = null;
    /** 创建开始毫秒时间 | 示例: 1773849600000 */
    public ?int $createMillTimeStart = null;
    /** 创建结束毫秒时间 | 示例: 1773936000000 */
    public ?int $createMillTimeEnd = null;
    /** 修改开始毫秒时间 | 示例: 1773849600000 */
    public ?int $modifyMillTimeStart = null;
    /** 修改结束毫秒时间 | 示例: 1773936000000 */
    public ?int $modifyMillTimeEnd = null;

    protected function wrapKey(): ?string
    {
        return 'input';
    }
}
