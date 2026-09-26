<?php

declare(strict_types=1);

/**
 * 1688 官方 SDK 参数类 → 现代 Request 类生成器
 *
 * 用法（在本包根目录下）：
 *   php bin/generate.php /path/to/官方SDK目录    # 必传：open.1688.com SDK 生成器下载的官方包根目录
 *   php bin/generate.php /path/to/官方SDK目录 --dry-run   # 只输出 API 清单不写文件
 *
 * 输入：官方生成包中各 namespace 的 param 目录下成对出现的
 *       XxxParam.class.php + XxxResult.class.php
 * 输出：src/Api/{Segment}/XxxRequest.php + src/Api/Registry.php
 *
 * 解析规则（对齐官方 Param2RequestSerializer 的序列化行为）：
 *  - 平铺型 Param（setter 写 sdkStdResult["key"]）→ 字段平铺为 Request 属性
 *  - 包裹型 Param（唯一字段引用内层模型类，如 param=FenXiaoKeyWordSearchParam）
 *    → 解析内层类字段平铺为属性，wrapKey() 返回包裹键
 *  - 嵌套模型字段（cargoParamList 等）→ 类型统一 array，PHPDoc 保留模型类名供参照
 *
 * ⚠️ apiName 由类名驼峰还原存在歧义：API_NAME_OVERRIDES 为人工核对表；
 *    未经联调确认的类一律带 @todo 注释，联调报 gw.APIUnsupported 时在此表修正重跑。
 */

error_reporting(E_ALL);

// ---------------------------------------------------------------------------
// 配置区
// ---------------------------------------------------------------------------

$outDir = dirname(__DIR__) . '/src/Api';

/** namespace → Api 子目录（PSR-4 段） */
const NS_SEGMENT = [
    'com.alibaba.account'            => 'Account',
    'com.alibaba.ai'                 => 'Ai',
    'com.alibaba.encrypt'            => 'Encrypt',
    'com.alibaba.fenxiao'            => 'Fenxiao',
    'com.alibaba.fenxiao.crossborder'=> 'Crossborder',
    'com.alibaba.industrial'         => 'Industrial',
    'com.alibaba.logistics'          => 'Logistics',
    'com.alibaba.marketing'          => 'Marketing',
    'com.alibaba.p4p'                => 'P4p',
    'com.alibaba.product'            => 'Product',
    'com.alibaba.trade'              => 'Trade',
    'cn.alibaba.open'                => 'CnOpen',
];

/** 人工核对的 apiName（key = Param 类名去掉 Param 后缀；未列出的用启发式推导并标 @todo） */
const API_NAME_OVERRIDES = [
    // 已验证（真实网关调用过）
    'AlibabaTradeGetBuyerOrderList' => 'alibaba.trade.getBuyerOrderList',
    // 高置信（官方文档/社区常见）
    'AlibabaTradeGetBuyerView'      => 'alibaba.trade.get.buyerView',
    'AlibabaTradeFastCreateOrder'   => 'alibaba.trade.fastCreateOrder',
    'AlibabaCreateOrderPreview'     => 'alibaba.createOrder.preview',
    'ProductKeywordsSearch'         => 'product.keywords.search',   // ✅ 2026-09-26 服务器实测通过
    'ProductKeywordSearch'          => 'productKeywordSearch',
    'AlibabaFenxiaoProductInfoGet'  => 'alibaba.fenxiao.product.info.get',
    'AlibabaFenxiaoRelationadd'     => 'alibaba.fenxiao.relationadd',
    'AlibabaFenxiaoChosenOfferlistGet' => 'alibaba.fenxiao.chosenOfferlist.get',
    'AlibabaFenxiaoChosenOfferlistRemoveall' => 'alibaba.fenxiao.chosenOfferlist.removeall',
    'AlibabaFeedbackOutProductAdd'  => 'alibaba.feedback.out.product.add',
    'AlibabaTradeGetLogisticsInfosBuyerView' => 'alibaba.trade.getLogisticsInfos.buyerView',
    'AlibabaTradeGetLogisticsTraceInfoBuyerView' => 'alibaba.trade.getLogisticsTraceInfo.buyerView',
    'PoolProductPull'               => 'pool.product.pull',
    'SupplyOfferFetchIdList'        => 'supply.offer.fetchIdList',
    'SupplySimilarOfferSearch'      => 'supply.similarOffer.search',
    'SupplyRecommendChangeOfferStartTask' => 'supply.recommendChangeOffer.startTask',
    'SupplyTaskStop'                => 'supply.task.stop',
    'DkeyGet'                       => 'dkey.get',
    'ProductDistributeCntGet'       => 'product.distributeCnt.get',
    'ProductDistributeCntPut'       => 'product.distributeCnt.put',
    'FenxiaoSourcingCreateSourcingRequisition' => 'fenxiao.sourcing.createSourcingRequisition',
    'FenxiaoSourcingCreateTopicRequisition' => 'fenxiao.sourcing.createTopicRequisition',
    'FenxiaoSourcingCreateSourcingOperation' => 'fenxiao.sourcing.createSourcingOperation',
    'FenxiaoSourcingGetSourcingRequisitionList' => 'fenxiao.sourcing.getSourcingRequisitionList',
    'FenxiaoSourcingGetSourcingResultList' => 'fenxiao.sourcing.getSourcingResultList',
    'FenxiaoSourcingGetHotCategorys' => 'fenxiao.sourcing.getHotCategorys',
    'FenxiaoSourcingGetTopicCalendarList' => 'fenxiao.sourcing.getTopicCalendarList',
    'FenxiaoSourcingCheckSourcingRequirement' => 'fenxiao.sourcing.checkSourcingRequirement',
    'FenxiaoSupplyAddMonitorProduct' => 'fenxiao.supply.addMonitorProduct',
    'FenxiaoSupplyDeleteMonitorProduct' => 'fenxiao.supply.deleteMonitorProduct',
    'FenxiaoSupplyQueryMonitorProductList' => 'fenxiao.supply.queryMonitorProductList',
    'FenxiaoWarehouseCreateOrder'   => 'fenxiao.warehouse.createOrder',
    'FenxiaoWarehouseQueryOrderDetail' => 'fenxiao.warehouse.queryOrderDetail',
    'FenxiaoWarehouseQueryWarehouseList' => 'fenxiao.warehouse.queryWarehouseList',
    'FenxiaoWarehouseCheckWarehouseOpenStatus' => 'fenxiao.warehouse.checkWarehouseOpenStatus',
    'FenxiaoOrderCreateReverseOrder' => 'fenxiao.order.createReverseOrder',
    'AlibabaTradeFenxiaoOrderCreate' => 'alibaba.trade.fenxiaoOrder.create',
    'AlibabaTradeCreateFenxiaoOrderPreview' => 'alibaba.trade.createFenxiaoOrder.preview',
    'CouponOptimalClaim'            => 'coupon.optimalClaim',
    'QycgSelfOpItemGetList'         => 'qycg.selfOpItem.getList',
    'TradeReceivegoodsConfirm'      => 'trade.receivegoodsConfirm',
    'TradeInvoiceApply'             => 'trade.invoice.apply',
    'TradeInvoiceApplyGetPageListBuyerView' => 'trade.invoiceApplyGetPageListBuyerView',
    'TradeInvoiceGetListBuyerView'  => 'trade.invoiceGetListBuyerView',
    'TradeInvoiceAmountGetList'     => 'trade.invoiceAmountGetList',
    'TradeInvoiceTitleAdd'          => 'trade.invoiceTitleAdd',
    'TradeInvoiceTitleGetPageList'  => 'trade.invoiceTitleGetPageList',
    'AlibabaOrderMemoAdd'           => 'alibaba.orderMemo.add',
    'AlibabaAccountBasic'           => 'alibaba.account.basic',
    'AlibabaOpenofferRedirect'      => 'alibaba.openoffer.redirect',
    'AlibabaCategoryGet'            => 'alibaba.category.get',
    'AlibabaCategorySearchByKeyword' => 'alibaba.category.searchByKeyword',
    'AlibabaCnAlibabaOpenTradeOrderReceiveGoods' => 'alibaba.cn.alibaba.open.trade.order.receiveGoods',
    'AlibabaTradeAddresscodeGet'    => 'alibaba.trade.addresscode.get',
    'AlibabaTradeAddresscodeGetchild' => 'alibaba.trade.addresscode.getchild',
    'AlibabaTradeAddresscodeParse'  => 'alibaba.trade.addresscode.parse',
    'AlibabaTradeCancel'            => 'alibaba.trade.cancel',
    'AlibabaTradeCancelRefund'      => 'alibaba.trade.cancelRefund',
    'AlibabaTradeCreateRefund'      => 'alibaba.trade.createRefund',
    'AlibabaTradeGetMaxRefundFee'   => 'alibaba.trade.getMaxRefundFee',
    'AlibabaTradeGetRefundReasonList' => 'alibaba.trade.getRefundReasonList',
    'AlibabaTradeGrouppayUrlGet'    => 'alibaba.trade.grouppayUrlGet',
    'AlibabaTradePayWayQuery'       => 'alibaba.trade.payWayQuery',
    'AlibabaTradePayProtocolPayIsopen' => 'alibaba.trade.payProtocolPayIsopen',
    'AlibabaTradePayProtocolPayPreparePay' => 'alibaba.trade.payProtocolPayPreparePay',
    'AlibabaAccountPeriodListBuyerView' => 'alibaba.accountPeriodListBuyerView',
    'OrderReceiveAddressBuyerUpdate' => 'orderReceiveAddressBuyerUpdate',
    'RepurchaseContractGet'         => 'repurchaseContract.get',
    'LogisticsDeliveryUrge'         => 'logistics.deliveryUrge',
    'WarehouseOrderOutbound'        => 'warehouse.order.outbound',
    'AlibabaLogisticsOpQueryLogisticCompanyList' => 'alibaba.logistics.op.queryLogisticCompanyList',
    'AlibabaLogisticsOpQueryLogisticCompanyListOffline' => 'alibaba.logistics.op.queryLogisticCompanyListOffline',
    'AlibabaLogisticsMyFreightTemplateListGet' => 'alibaba.logistics.myFreightTemplateList.get',
    'AccountWangwangUrlGet'         => 'account.wangwang.url.get',
    'OpenAgentDeepSearch'           => 'open.agent.deepSearch',
    'OpenAgentSupplyChange'         => 'open.agent.supplyChange',
    'OpenAgentSupplyChangeDataFeedback' => 'open.agent.supplyChangeDataFeedback',
    'RefundAddressGet'              => 'refundAddress.get',
    'AlibabaTradeRefundBuyerQueryOrderRefundList' => 'alibaba.trade.refundBuyerQueryOrderRefundList',
    'AlibabaTradeRefundOpQueryOrderRefund' => 'alibaba.trade.refundOpQueryOrderRefund',
    'AlibabaTradeRefundOpQueryOrderRefundOperationList' => 'alibaba.trade.refundOpQueryOrderRefundOperationList',
    'AlibabaTradeRefundOpQueryBatchRefundByOrderIdAndStatus' => 'alibaba.trade.refundOpQueryBatchRefundByOrderIdAndStatus',
    'AlibabaTradeRefundReturnGoods' => 'alibaba.trade.refundReturnGoods',
    'AlibabaTradeUploadRefundVoucher' => 'alibaba.trade.uploadRefundVoucher',
    'AlibabaProductFollow'          => 'alibaba.product.follow',
    'AlibabaProductUnfollowCrossborder' => 'alibaba.product.unfollowCrossborder',
    'ProductSkuinfoGet'             => 'product.skuinfo.get',
    'AlibabaPublicImageSimilarOfferSearch' => 'alibaba.public.image.similarOffer.search',
];

/** 标量类型白名单（其余类型名视为内层模型类引用） */
const SCALAR_TYPES = [
    'string', 'String', 'long', 'Long', 'int', 'Integer', 'boolean', 'Boolean',
    'double', 'Double', 'float', 'Float', 'array', 'Array', 'Object', 'object', 'mixed',
];

// ---------------------------------------------------------------------------
// 主流程
// ---------------------------------------------------------------------------

$dryRun = in_array('--dry-run', $argv, true);
$sdkPath = '';
foreach ($argv as $i => $arg) {
    if ($i > 0 && $arg !== '--dry-run' && strpos($arg, '--') !== 0) {
        $sdkPath = $arg;
    }
}
if ($sdkPath === '') {
    fwrite(STDERR, "用法: php bin/generate.php /path/to/官方SDK目录 [--dry-run]\n（官方包 = open.1688.com SDK 生成器下载的 PHP 包根目录，含 com|cn 命名空间目录树）\n");
    exit(1);
}
if (!is_dir($sdkPath)) {
    fwrite(STDERR, "官方 SDK 路径不存在: {$sdkPath}\n");
    exit(1);
}

// 收集所有 param 目录下的类（类名 → 文件路径，供内层模型类反查）
$classIndex = [];
$apiClasses = []; // ['ns' =>, 'classBase' =>, 'file' =>]
foreach (NS_SEGMENT as $ns => $segment) {
    $dir = $sdkPath . '/' . str_replace('.', '/', $ns) . '/param';
    if (!is_dir($dir)) {
        continue;
    }
    foreach (glob($dir . '/*.class.php') ?: [] as $file) {
        $className = basename($file, '.class.php');
        $classIndex[$className] = $file;
        if (preg_match('/^(.+)Param$/', $className, $m) && is_file($dir . '/' . $m[1] . 'Result.class.php')) {
            $apiClasses[] = ['ns' => $ns, 'classBase' => $m[1], 'file' => $file];
        }
    }
}

fwrite(STDOUT, '发现 API（Param+Result 成对）：' . count($apiClasses) . " 个\n");

$generated = [];
$todoCount = 0;
foreach ($apiClasses as $api) {
    $result = generateOne($api, $classIndex);
    if ($result === null) {
        fwrite(STDOUT, '  [跳过] ' . $api['ns'] . ':' . $api['classBase'] . "\n");
        continue;
    }
    [$php, $shortName, $apiName, $confirmed] = $result;
    $generated[] = [
        'ns' => $api['ns'],
        'segment' => NS_SEGMENT[$api['ns']],
        'short' => $shortName,
        'api' => $api['ns'] . ':' . $apiName . '-1',
        'confirmed' => $confirmed,
    ];
    if (!$confirmed) {
        $todoCount++;
    }
    if (!$dryRun) {
        $dir = $outDir . '/' . NS_SEGMENT[$api['ns']];
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($dir . '/' . $shortName . 'Request.php', $php);
    }
}

// 生成 Registry
if (!$dryRun) {
    file_put_contents($outDir . '/Registry.php', buildRegistry($generated));
}
fwrite(STDOUT, sprintf("完成：%d 个 Request 类 + Registry（其中 %d 个 apiName 待联调核对）\n", count($generated), $todoCount));
if ($dryRun) {
    foreach ($generated as $g) {
        fwrite(STDOUT, sprintf("  %-12s %-45s %s%s\n", $g['segment'], $g['short'], $g['api'], $g['confirmed'] ? '' : '  @todo'));
    }
}

// ---------------------------------------------------------------------------
// 生成单个类
// ---------------------------------------------------------------------------

/**
 * @return array{0: string, 1: string, 2: string, 3: bool}|null [php代码, 短类名, apiName, 是否已确认]
 */
function generateOne(array $api, array $classIndex): ?array
{
    $ns = $api['ns'];
    $classBase = $api['classBase'];

    // apiName：覆盖表优先，否则启发式（ns 前缀剥离 + lcfirst）
    $confirmed = isset(API_NAME_OVERRIDES[$classBase]);
    $apiName = API_NAME_OVERRIDES[$classBase] ?? heuristicApiName($ns, $classBase);

    // 短类名：剥离 ns 驼峰前缀
    $shortName = stripNsPrefix($ns, $classBase);
    if ($shortName === '') {
        return null;
    }

    // 解析外层 Param 字段
    $fields = parseParamFields((string)file_get_contents($api['file']));

    // 包裹型检测：唯一字段且类型为内层模型类
    $wrapKey = null;
    if (count($fields) === 1 && isset($fields[0]['model']) && $fields[0]['model'] !== '') {
        $innerClass = $fields[0]['model'];
        if (isset($classIndex[$innerClass])) {
            $innerFields = parseParamFields((string)file_get_contents($classIndex[$innerClass]));
            if ($innerFields) {
                $wrapKey = $fields[0]['field'];
                $fields = $innerFields;
            }
        }
    }

    // 类型映射 + 属性代码
    $props = [];
    foreach ($fields as $f) {
        $props[] = renderProperty($f);
    }

    $segment = NS_SEGMENT[$ns];
    $todo = $confirmed ? '' : "\n * @todo 联调核对 apiName（驼峰还原可能有歧义，报 gw.APIUnsupported 时改 bin/generate.php 的 API_NAME_OVERRIDES 后重跑）";
    $wrapMethod = $wrapKey !== null
        ? "\n    protected function wrapKey(): ?string\n    {\n        return '{$wrapKey}';\n    }\n"
        : '';

    $php = "<?php\n\ndeclare(strict_types=1);\n\nnamespace Is4ngle\\AlibabaOpen\\Api\\{$segment};\n\nuse Is4ngle\\AlibabaOpen\\Request\\AbstractRequest;\n\n/**\n * API: {$ns}:{$apiName}-1\n * 生成自官方 SDK 参数类 {$classBase}Param（bin/generate.php，勿手改，重跑覆盖）{$todo}\n */\nfinal class {$shortName}Request extends AbstractRequest\n{\n    public function getNamespace(): string\n    {\n        return '{$ns}';\n    }\n\n    public function getApiName(): string\n    {\n        return '{$apiName}';\n    }\n\n" . implode("\n", $props) . "\n{$wrapMethod}}\n";

    return [$php, $shortName, $apiName, $confirmed];
}

/**
 * 解析 Param/Model 类字段（兼容两种官方风格）。
 *
 * @return array<int, array{field: string, type: string, array: bool, model: string, doc: string, required: bool, example: string}>
 */
function parseParamFields(string $src): array
{
    $fields = [];
    // docblock（内容禁含 */，避免吞并相邻 getter 的注释）+ setter（风格A写 sdkStdResult["key"]，风格B写 $this->prop）
    if (!preg_match_all('/\/\*\*((?:[^*]|\*(?!\/))*)\*\/\s*public\s+function\s+set(\w+)\s*\(([^)]*)\)\s*\{([^}]*)\}/s', $src, $m, PREG_SET_ORDER)) {
        return $fields;
    }
    foreach ($m as $match) {
        [$all, $doc, $methodSuffix, $args, $body] = $match;

        // 字段名：优先 sdkStdResult["key"]，其次 $this->prop
        $field = null;
        if (preg_match('/sdkStdResult\["([^"]+)"\]/', $body, $fm)) {
            $field = $fm[1];
        } elseif (preg_match('/\$this->(\w+)\s*=/', $body, $fm)) {
            $field = $fm[1];
        }
        if ($field === null) {
            continue;
        }

        // 类型：@param Type $var；数组形态可能是 "Type[]" 或 "@param array include @see String[]"
        $type = 'String';
        if (preg_match('/@param\s+(\w+)/', $doc, $tm)) {
            $type = $tm[1];
        } elseif (preg_match('/\(\s*(\w+)/', $args, $tm)) {
            $type = $tm[1];
        }
        $isArray = (bool)preg_match('/\[\]/', $doc);

        // 说明：docblock 中 "@param" 之前的文本（去掉 设置 前缀与装饰）
        $descLines = [];
        foreach (preg_split('/\n/', $doc) as $line) {
            $line = trim(preg_replace('/^\s*\*\s?/', '', trim($line)));
            if ($line === '' || $line === '/**' || strpos($line, '@param') === 0 || $line === '**/') {
                continue;
            }
            $descLines[] = $line;
        }
        $doc = trim(implode('；', array_filter($descLines, static fn($l) => trim($l) !== '')));
        $doc = preg_replace('/^设置/', '', $doc) ?? '';
        $doc = trim((string)preg_replace('/(；\s*)+/', '；', $doc), '； ');

        $example = '';
        if (preg_match('/参数示例：<pre>(.*?)<\/pre>/s', $doc, $em)) {
            $example = trim(preg_replace('/\s+/', ' ', $em[1]));
            $doc = trim(preg_replace('/参数示例：<pre>.*?<\/pre>/s', '', $doc));
        }
        $required = strpos($doc, '此参数必填') !== false;
        $doc = trim(str_replace('此参数必填', '', $doc));
        // 最终清理：残留的分隔符与空白
        $doc = trim((string)preg_replace('/(；\s*)+/', '；', $doc), '； ');

        $model = (!in_array($type, SCALAR_TYPES, true)) ? $type : '';

        $fields[] = [
            'field' => $field,
            'type' => $type,
            'array' => $isArray,
            'model' => $model,
            'doc' => $doc,
            'required' => $required,
            'example' => $example,
        ];
    }
    return $fields;
}

/**
 * 字段 → PHP typed 属性代码。
 */
function renderProperty(array $f): string
{
    $isArray = $f['array'] || $f['model'] !== '';
    if ($isArray) {
        $phpType = '?array';
        $default = 'null';
    } else {
        switch ($f['type']) {
            case 'Long': case 'long': case 'Integer': case 'int':
                $phpType = '?int'; $default = 'null'; break;
            case 'Boolean': case 'boolean':
                $phpType = '?bool'; $default = 'null'; break;
            case 'Double': case 'double': case 'Float': case 'float':
                $phpType = '?float'; $default = 'null'; break;
            default:
                $phpType = '?string'; $default = 'null';
        }
    }

    $notes = [];
    if ($f['doc'] !== '') {
        $notes[] = $f['doc'];
    }
    if ($f['example'] !== '') {
        $notes[] = '示例: ' . $f['example'];
    }
    // 官方 docblock 把所有字段都标"此参数必填"，不可信，不输出
    if ($f['model'] !== '') {
        $notes[] = '嵌套模型: ' . $f['model'] . ($f['array'] ? '[]' : '');
    }
    $comment = $notes ? '/** ' . implode(' | ', $notes) . ' */' : '';

    return ($comment !== '' ? '    ' . $comment . "\n" : '') . "    public {$phpType} \${$f['field']} = {$default};";
}

/**
 * 启发式 apiName：类名剥离 ns 驼峰前缀 → lcfirst。
 */
function heuristicApiName(string $ns, string $classBase): string
{
    $stripped = stripNsPrefix($ns, $classBase);
    if ($stripped === '') {
        $stripped = $classBase;
    }
    return lcfirst($stripped);
}

/**
 * 从类名剥离 namespace 的驼峰前缀（com.alibaba.trade + AlibabaTradeGetBuyerView → GetBuyerView）。
 */
function stripNsPrefix(string $ns, string $classBase): string
{
    $nsParts = explode('.', $ns);
    $nsCamel = implode('', array_map('ucfirst', $nsParts)); // ComAlibabaTrade
    // 官方类名前缀是 ns 的点分形式首段大写（AlibabaTrade... 对 com.alibaba.trade）
    $prefix = implode('', array_map('ucfirst', $nsParts));
    // 尝试多种前缀形态：全 ns（ComAlibabaTrade）、去首段（AlibabaTrade）、末段（Trade）
    $candidates = array_unique([$nsCamel, implode('', array_map('ucfirst', array_slice($nsParts, 1)))]);
    foreach ($candidates as $cand) {
        if (stripos($classBase, $cand) === 0 && strlen($classBase) > strlen($cand)) {
            return substr($classBase, strlen($cand));
        }
    }
    // 不带前缀的类名（如 ProductKeywordsSearch）：直接用
    return $classBase;
}

/**
 * 生成 Registry.php。
 */
function buildRegistry(array $generated): string
{
    $entries = [];
    foreach ($generated as $g) {
        $entries[] = sprintf(
            "    '%s' => ['class' => \\Is4ngle\\AlibabaOpen\\Api\\%s\\%sRequest::class, 'api' => '%s'%s],",
            $g['short'],
            $g['segment'],
            $g['short'],
            $g['api'],
            $g['confirmed'] ? '' : ", 'todo' => true"
        );
    }
    return "<?php\n\ndeclare(strict_types=1);\n\nnamespace Is4ngle\\AlibabaOpen\\Api;\n\n/**\n * API 注册表（bin/generate.php 生成，勿手改）。\n * key = Request 短类名（去 Request 后缀），供调试入口/批量联调查找。\n */\nfinal class Registry\n{\n    public const MAP = [\n" . implode("\n", $entries) . "\n    ];\n\n    /** @return array<string, array{class: string, api: string, todo?: bool}> */\n    public static function all(): array\n    {\n        return self::MAP;\n    }\n\n    public static function find(string \$shortName): ?array\n    {\n        return self::MAP[\$shortName] ?? null;\n    }\n}\n";
}
