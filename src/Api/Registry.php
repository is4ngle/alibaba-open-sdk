<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Api;

/**
 * API 注册表（bin/generate.php 生成，勿手改）。
 * key = Request 短类名（去 Request 后缀），供调试入口/批量联调查找。
 */
final class Registry
{
    public const MAP = [
    'Basic' => ['class' => \Is4ngle\AlibabaOpen\Api\Account\BasicRequest::class, 'api' => 'com.alibaba.account:alibaba.account.basic-1'],
    'OpenAgentDeepSearch' => ['class' => \Is4ngle\AlibabaOpen\Api\Ai\OpenAgentDeepSearchRequest::class, 'api' => 'com.alibaba.ai:open.agent.deepSearch-1'],
    'OpenAgentSupplyChangeDataFeedback' => ['class' => \Is4ngle\AlibabaOpen\Api\Ai\OpenAgentSupplyChangeDataFeedbackRequest::class, 'api' => 'com.alibaba.ai:open.agent.supplyChangeDataFeedback-1'],
    'OpenAgentSupplyChange' => ['class' => \Is4ngle\AlibabaOpen\Api\Ai\OpenAgentSupplyChangeRequest::class, 'api' => 'com.alibaba.ai:open.agent.supplyChange-1'],
    'AlibabaOpenofferRedirect' => ['class' => \Is4ngle\AlibabaOpen\Api\Encrypt\AlibabaOpenofferRedirectRequest::class, 'api' => 'com.alibaba.encrypt:alibaba.openoffer.redirect-1'],
    'BuyerOutproductRelationAdd' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutproductRelationAddRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutproductRelationAdd-1', 'todo' => true],
    'BuyerOutproductRelationDelete' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutproductRelationDeleteRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutproductRelationDelete-1', 'todo' => true],
    'BuyerOutproductRelationGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutproductRelationGetRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutproductRelationGet-1', 'todo' => true],
    'BuyerOutshopAdd' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutshopAddRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutshopAdd-1', 'todo' => true],
    'BuyerOutshopDelete' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutshopDeleteRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutshopDelete-1', 'todo' => true],
    'ChosenOfferlistGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ChosenOfferlistGetRequest::class, 'api' => 'com.alibaba.fenxiao:alibaba.fenxiao.chosenOfferlist.get-1'],
    'ChosenOfferlistRemoveall' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ChosenOfferlistRemoveallRequest::class, 'api' => 'com.alibaba.fenxiao:alibaba.fenxiao.chosenOfferlist.removeall-1'],
    'ProductInfoGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ProductInfoGetRequest::class, 'api' => 'com.alibaba.fenxiao:alibaba.fenxiao.product.info.get-1'],
    'Relationadd' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\RelationaddRequest::class, 'api' => 'com.alibaba.fenxiao:alibaba.fenxiao.relationadd-1'],
    'AlibabaTradeCreateFenxiaoOrderPreview' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\AlibabaTradeCreateFenxiaoOrderPreviewRequest::class, 'api' => 'com.alibaba.fenxiao:alibaba.trade.createFenxiaoOrder.preview-1'],
    'BuyerOutshopFeedback' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\BuyerOutshopFeedbackRequest::class, 'api' => 'com.alibaba.fenxiao:buyerOutshopFeedback-1', 'todo' => true],
    'DkeyGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\DkeyGetRequest::class, 'api' => 'com.alibaba.fenxiao:dkey.get-1'],
    'FenxiaoAimaterialGetDetail' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoAimaterialGetDetailRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoAimaterialGetDetail-1', 'todo' => true],
    'FenxiaoBenefitCheckCreditBenefit' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoBenefitCheckCreditBenefitRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoBenefitCheckCreditBenefit-1', 'todo' => true],
    'FenxiaoBenefitCheckKaUser' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoBenefitCheckKaUserRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoBenefitCheckKaUser-1', 'todo' => true],
    'FenxiaoBenefitCreateCreditBenefit' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoBenefitCreateCreditBenefitRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoBenefitCreateCreditBenefit-1', 'todo' => true],
    'FenxiaoBrandQueryAuth' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoBrandQueryAuthRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoBrandQueryAuth-1', 'todo' => true],
    'FenxiaoDistributebillGetList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoDistributebillGetListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoDistributebillGetList-1', 'todo' => true],
    'FenxiaoDistributebillRemoveall' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoDistributebillRemoveallRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoDistributebillRemoveall-1', 'todo' => true],
    'FenxiaoHitlabQueryHitLabBatch' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoHitlabQueryHitLabBatchRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoHitlabQueryHitLabBatch-1', 'todo' => true],
    'FenxiaoHitlabQueryHitLabItem' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoHitlabQueryHitLabItemRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoHitlabQueryHitLabItem-1', 'todo' => true],
    'FenxiaoOrderCreateReverseOrder' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoOrderCreateReverseOrderRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.order.createReverseOrder-1'],
    'FenxiaoRiskQueryGoodsRisk' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoRiskQueryGoodsRiskRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoRiskQueryGoodsRisk-1', 'todo' => true],
    'FenxiaoSourcingCheckSourcingRequirement' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingCheckSourcingRequirementRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.checkSourcingRequirement-1'],
    'FenxiaoSourcingCreateSourcingOperation' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingCreateSourcingOperationRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.createSourcingOperation-1'],
    'FenxiaoSourcingCreateSourcingRequisition' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingCreateSourcingRequisitionRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.createSourcingRequisition-1'],
    'FenxiaoSourcingCreateTopicRequisition' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingCreateTopicRequisitionRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.createTopicRequisition-1'],
    'FenxiaoSourcingGetHotCategorys' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingGetHotCategorysRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.getHotCategorys-1'],
    'FenxiaoSourcingGetSourcingRequisitionList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingGetSourcingRequisitionListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.getSourcingRequisitionList-1'],
    'FenxiaoSourcingGetSourcingResultList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingGetSourcingResultListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.getSourcingResultList-1'],
    'FenxiaoSourcingGetTopicCalendarList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSourcingGetTopicCalendarListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.sourcing.getTopicCalendarList-1'],
    'FenxiaoSupplyAddMonitorProduct' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSupplyAddMonitorProductRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.supply.addMonitorProduct-1'],
    'FenxiaoSupplyDeleteMonitorProduct' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSupplyDeleteMonitorProductRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.supply.deleteMonitorProduct-1'],
    'FenxiaoSupplyQueryMonitorProductList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSupplyQueryMonitorProductListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.supply.queryMonitorProductList-1'],
    'FenxiaoSupportQueryKnowledge' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoSupportQueryKnowledgeRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiaoSupportQueryKnowledge-1', 'todo' => true],
    'FenxiaoWarehouseCheckWarehouseOpenStatus' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoWarehouseCheckWarehouseOpenStatusRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.warehouse.checkWarehouseOpenStatus-1'],
    'FenxiaoWarehouseCreateOrder' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoWarehouseCreateOrderRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.warehouse.createOrder-1'],
    'FenxiaoWarehouseQueryOrderDetail' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoWarehouseQueryOrderDetailRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.warehouse.queryOrderDetail-1'],
    'FenxiaoWarehouseQueryWarehouseList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\FenxiaoWarehouseQueryWarehouseListRequest::class, 'api' => 'com.alibaba.fenxiao:fenxiao.warehouse.queryWarehouseList-1'],
    'ProductDistributeCntGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ProductDistributeCntGetRequest::class, 'api' => 'com.alibaba.fenxiao:product.distributeCnt.get-1'],
    'ProductDistributeCntPut' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ProductDistributeCntPutRequest::class, 'api' => 'com.alibaba.fenxiao:product.distributeCnt.put-1'],
    'ProductKeywordsSearch' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\ProductKeywordsSearchRequest::class, 'api' => 'com.alibaba.fenxiao:product.keywords.search-1'],
    'RefundAddressGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\RefundAddressGetRequest::class, 'api' => 'com.alibaba.fenxiao:refundAddress.get-1'],
    'SupplyOfferFetchIdList' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\SupplyOfferFetchIdListRequest::class, 'api' => 'com.alibaba.fenxiao:supply.offer.fetchIdList-1'],
    'SupplyRecommendChangeOfferStartTask' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\SupplyRecommendChangeOfferStartTaskRequest::class, 'api' => 'com.alibaba.fenxiao:supply.recommendChangeOffer.startTask-1'],
    'SupplySimilarOfferSearch' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\SupplySimilarOfferSearchRequest::class, 'api' => 'com.alibaba.fenxiao:supply.similarOffer.search-1'],
    'SupplyTaskStop' => ['class' => \Is4ngle\AlibabaOpen\Api\Fenxiao\SupplyTaskStopRequest::class, 'api' => 'com.alibaba.fenxiao:supply.task.stop-1'],
    'PoolProductPull' => ['class' => \Is4ngle\AlibabaOpen\Api\Crossborder\PoolProductPullRequest::class, 'api' => 'com.alibaba.fenxiao.crossborder:pool.product.pull-1'],
    'QycgSelfOpItemGetList' => ['class' => \Is4ngle\AlibabaOpen\Api\Industrial\QycgSelfOpItemGetListRequest::class, 'api' => 'com.alibaba.industrial:qycg.selfOpItem.getList-1'],
    'MyFreightTemplateListGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\MyFreightTemplateListGetRequest::class, 'api' => 'com.alibaba.logistics:alibaba.logistics.myFreightTemplateList.get-1'],
    'OpQueryLogisticCompanyListOffline' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\OpQueryLogisticCompanyListOfflineRequest::class, 'api' => 'com.alibaba.logistics:alibaba.logistics.op.queryLogisticCompanyListOffline-1'],
    'OpQueryLogisticCompanyList' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\OpQueryLogisticCompanyListRequest::class, 'api' => 'com.alibaba.logistics:alibaba.logistics.op.queryLogisticCompanyList-1'],
    'AlibabaTradeGetLogisticsInfosBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\AlibabaTradeGetLogisticsInfosBuyerViewRequest::class, 'api' => 'com.alibaba.logistics:alibaba.trade.getLogisticsInfos.buyerView-1'],
    'AlibabaTradeGetLogisticsTraceInfoBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\AlibabaTradeGetLogisticsTraceInfoBuyerViewRequest::class, 'api' => 'com.alibaba.logistics:alibaba.trade.getLogisticsTraceInfo.buyerView-1'],
    'LogisticsDeliveryUrge' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\LogisticsDeliveryUrgeRequest::class, 'api' => 'com.alibaba.logistics:logistics.deliveryUrge-1'],
    'WarehouseOrderOutbound' => ['class' => \Is4ngle\AlibabaOpen\Api\Logistics\WarehouseOrderOutboundRequest::class, 'api' => 'com.alibaba.logistics:warehouse.order.outbound-1'],
    'CouponOptimalClaim' => ['class' => \Is4ngle\AlibabaOpen\Api\Marketing\CouponOptimalClaimRequest::class, 'api' => 'com.alibaba.marketing:coupon.optimalClaim-1'],
    'AlibabaCpsQueryOfferDetailActivity' => ['class' => \Is4ngle\AlibabaOpen\Api\P4p\AlibabaCpsQueryOfferDetailActivityRequest::class, 'api' => 'com.alibaba.p4p:alibabaCpsQueryOfferDetailActivity-1', 'todo' => true],
    'AlibabaCategoryGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\AlibabaCategoryGetRequest::class, 'api' => 'com.alibaba.product:alibaba.category.get-1'],
    'AlibabaCategorySearchByKeyword' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\AlibabaCategorySearchByKeywordRequest::class, 'api' => 'com.alibaba.product:alibaba.category.searchByKeyword-1'],
    'Follow' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\FollowRequest::class, 'api' => 'com.alibaba.product:alibaba.product.follow-1'],
    'UnfollowCrossborder' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\UnfollowCrossborderRequest::class, 'api' => 'com.alibaba.product:alibaba.product.unfollowCrossborder-1'],
    'AlibabaPublicImageSimilarOfferSearch' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\AlibabaPublicImageSimilarOfferSearchRequest::class, 'api' => 'com.alibaba.product:alibaba.public.image.similarOffer.search-1'],
    'ProductKeywordSearch' => ['class' => \Is4ngle\AlibabaOpen\Api\Product\ProductKeywordSearchRequest::class, 'api' => 'com.alibaba.product:productKeywordSearch-1'],
    'AlibabaAccountPeriodListBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AlibabaAccountPeriodListBuyerViewRequest::class, 'api' => 'com.alibaba.trade:alibaba.accountPeriodListBuyerView-1'],
    'AlibabaCreateOrderPreview' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AlibabaCreateOrderPreviewRequest::class, 'api' => 'com.alibaba.trade:alibaba.createOrder.preview-1'],
    'AlibabaOrderMemoAdd' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AlibabaOrderMemoAddRequest::class, 'api' => 'com.alibaba.trade:alibaba.orderMemo.add-1'],
    'AddresscodeGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AddresscodeGetRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.addresscode.get-1'],
    'AddresscodeGetchild' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AddresscodeGetchildRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.addresscode.getchild-1'],
    'AddresscodeParse' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\AddresscodeParseRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.addresscode.parse-1'],
    'Cancel' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\CancelRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.cancel-1'],
    'CancelRefund' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\CancelRefundRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.cancelRefund-1'],
    'CreateRefund' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\CreateRefundRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.createRefund-1'],
    'FenxiaoOrderCreate' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\FenxiaoOrderCreateRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.fenxiaoOrder.create-1'],
    'GetBuyerOrderList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\GetBuyerOrderListRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.getBuyerOrderList-1'],
    'GetBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\GetBuyerViewRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.get.buyerView-1'],
    'GetMaxRefundFee' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\GetMaxRefundFeeRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.getMaxRefundFee-1'],
    'GetRefundReasonList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\GetRefundReasonListRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.getRefundReasonList-1'],
    'GrouppayUrlGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\GrouppayUrlGetRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.grouppayUrlGet-1'],
    'PayProtocolPayIsopen' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\PayProtocolPayIsopenRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.payProtocolPayIsopen-1'],
    'PayProtocolPayPreparePay' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\PayProtocolPayPreparePayRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.payProtocolPayPreparePay-1'],
    'PayWayQuery' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\PayWayQueryRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.payWayQuery-1'],
    'RefundBuyerQueryOrderRefundList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RefundBuyerQueryOrderRefundListRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.refundBuyerQueryOrderRefundList-1'],
    'RefundOpQueryBatchRefundByOrderIdAndStatus' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RefundOpQueryBatchRefundByOrderIdAndStatusRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.refundOpQueryBatchRefundByOrderIdAndStatus-1'],
    'RefundOpQueryOrderRefundOperationList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RefundOpQueryOrderRefundOperationListRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.refundOpQueryOrderRefundOperationList-1'],
    'RefundOpQueryOrderRefund' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RefundOpQueryOrderRefundRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.refundOpQueryOrderRefund-1'],
    'RefundReturnGoods' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RefundReturnGoodsRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.refundReturnGoods-1'],
    'UploadRefundVoucher' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\UploadRefundVoucherRequest::class, 'api' => 'com.alibaba.trade:alibaba.trade.uploadRefundVoucher-1'],
    'OrderReceiveAddressBuyerUpdate' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\OrderReceiveAddressBuyerUpdateRequest::class, 'api' => 'com.alibaba.trade:orderReceiveAddressBuyerUpdate-1'],
    'RepurchaseContractGet' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\RepurchaseContractGetRequest::class, 'api' => 'com.alibaba.trade:repurchaseContract.get-1'],
    'TradeEncryptOutOrderInfoModify' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeEncryptOutOrderInfoModifyRequest::class, 'api' => 'com.alibaba.trade:tradeEncryptOutOrderInfoModify-1', 'todo' => true],
    'TradeInvoiceAmountGetList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceAmountGetListRequest::class, 'api' => 'com.alibaba.trade:trade.invoiceAmountGetList-1'],
    'TradeInvoiceApplyGetPageListBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceApplyGetPageListBuyerViewRequest::class, 'api' => 'com.alibaba.trade:trade.invoiceApplyGetPageListBuyerView-1'],
    'TradeInvoiceApply' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceApplyRequest::class, 'api' => 'com.alibaba.trade:trade.invoice.apply-1'],
    'TradeInvoiceConsult' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceConsultRequest::class, 'api' => 'com.alibaba.trade:tradeInvoiceConsult-1', 'todo' => true],
    'TradeInvoiceGetListBuyerView' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceGetListBuyerViewRequest::class, 'api' => 'com.alibaba.trade:trade.invoiceGetListBuyerView-1'],
    'TradeInvoiceMergeapply' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceMergeapplyRequest::class, 'api' => 'com.alibaba.trade:tradeInvoiceMergeapply-1', 'todo' => true],
    'TradeInvoiceTitleAdd' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceTitleAddRequest::class, 'api' => 'com.alibaba.trade:trade.invoiceTitleAdd-1'],
    'TradeInvoiceTitleGetPageList' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeInvoiceTitleGetPageListRequest::class, 'api' => 'com.alibaba.trade:trade.invoiceTitleGetPageList-1'],
    'TradeReceivegoodsConfirm' => ['class' => \Is4ngle\AlibabaOpen\Api\Trade\TradeReceivegoodsConfirmRequest::class, 'api' => 'com.alibaba.trade:trade.receivegoodsConfirm-1'],
    'AlibabaCnAlibabaOpenTradeOrderReceiveGoods' => ['class' => \Is4ngle\AlibabaOpen\Api\CnOpen\AlibabaCnAlibabaOpenTradeOrderReceiveGoodsRequest::class, 'api' => 'cn.alibaba.open:alibaba.cn.alibaba.open.trade.order.receiveGoods-1'],
    ];

    /** @return array<string, array{class: string, api: string, todo?: bool}> */
    public static function all(): array
    {
        return self::MAP;
    }

    public static function find(string $shortName): ?array
    {
        return self::MAP[$shortName] ?? null;
    }
}
