# is4ngle/alibaba-open-sdk

1688 开放平台「代发解决方案（分销买家版）」PHP SDK。

## 能力

- **106 个业务 API**（选品/订单/物流/售后/渠道/云仓全链路）：每个 API 一个 Request 类（`src/Api/`），由生成器从官方 SDK 参数类转换，清单见 `Api\Registry`
- **通用网关客户端**：任意 API 通过 `call(ns, apiName, version, params)` 直调，自动处理 AOP param2 签名、公共参数、限流重试（gw.QosRequestLimit 指数退避）、错误分层
- **消息推送**：HTTP 回调验签（CallbackVerifier）+ WebSocket 长连接状态机（CONNECT/心跳/CONFIRM 回执/断线重连/msgId 去重）

## 环境要求

- PHP >= 8.0（未用 8.1+ 语法）
- guzzlehttp/guzzle ^7.4（经 `TransportInterface` 可替换，强制 SSL 校验）
- 可选：ext-swoole（协程 WS 传输）、psr/log

## 快速上手

```php
use Is4ngle\AlibabaOpen\Client;
use Is4ngle\AlibabaOpen\Config\Credentials;
use Is4ngle\AlibabaOpen\Api\Fenxiao\ProductKeywordsSearchRequest;

$client = new Client(new Credentials($appKey, $appSecret, $accessToken));

// 方式一：Request 对象（推荐，参数有类型和注释提示）
$req = new ProductKeywordsSearchRequest();
$req->keywords = '保温杯';
$req->pageNum = 1;
$req->pageSize = 20;
$req->filter = ['fxBrandOffer'];           // 分销品牌黑标

$resp = $client->execute($req);
if ($resp->isSuccess()) {
    $offers = $resp->result();             // 商品数组（含代发价/阶梯价/包邮/星级）
} else {
    $resp->getErrorCode();                 // 业务错误
    $resp->getRaw();                       // 原始响应兜底
}

// 方式二：通用直调（未封装/调试）
$resp = $client->call('com.alibaba.trade', 'alibaba.trade.getBuyerOrderList', 1, ['page' => 1]);
```

网关级错误（HTTP 非 2xx / gw.* 错误码 / 网络 / 非 JSON）抛 `GatewayException`，业务失败不抛异常。

消息推送（回调验签 / WebSocket 消费）见 `examples/`。

## API 清单

`src/Api/` 按命名空间分目录（Fenxiao/Product/Trade/Logistics/...），`Api\Registry::all()` 返回全量映射。部分 apiName 由类名驼峰还原、待联调核对（Registry 中标 `todo`）：报 `gw.APIUnsupported` 时改 `bin/generate.php` 的 `API_NAME_OVERRIDES` 表重跑生成器即可修正。

## 生成器

`bin/generate.php` 从官方 SDK 参数类（应用已订阅 API 的生成物）一次性转换出 `src/Api/`：

```bash
php bin/generate.php /path/to/官方SDK目录    # 必传：open.1688.com SDK 生成器下载的官方包根目录
php bin/generate.php /path/to/官方SDK目录 --dry-run    # 只看清单
```

生成产物独立无依赖（官方包仅作一次性输入，运行时不引用）。

## 测试

```bash
composer install && vendor/bin/phpunit
```

覆盖：三个签名器黄金向量、网关 Mock 集成、WS 状态机、回调验签、生成类抽样（平铺/包裹/嵌套）+ 全量实例化冒烟。

## 已知限制

- access_token 假定外部持久提供（`Credentials` 支持 `tokenProvider` 刷新钩子）
- `todo` 标记的 apiName 及各 API 真实响应结构以联调为准
