<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Sign;

/**
 * HTTP 回调通道验签器（消息推送，平台 -> ISV）。
 *
 * 签名算法（移植自官方 tuna SDK SignatureUtil.hmacSha1(Map, key) + SimpleHttpProcessorHandler）：
 *  1. 取 query + body 合并后的全部参数，剔除 _aop_signature 自身；
 *  2. 每个参数拼成 "key+value" 整体串，对【串列表】做字典序排序（注意：排序的是整体串，不是 key）；
 *  3. 依次拼接后用 appSecret 做 HMAC-SHA1，输出大写十六进制串；
 *  4. 与请求中的 _aop_signature 忽略大小写比较。
 *
 * 本类无状态、纯函数。
 */
final class CallbackSigner
{
    /**
     * 计算签名。
     *
     * @param array<string, mixed> $params 已合并 query+form 的参数（含或不含 _aop_signature 均可，内部剔除）
     */
    public static function sign(array $params, string $appSecret): string
    {
        $toSort = [];
        foreach ($params as $key => $value) {
            $key = (string)$key;
            if ($key === '_aop_signature') {
                continue;
            }
            if ($value === null) {
                continue;
            }
            $toSort[] = $key . self::stringify($value);
        }
        sort($toSort, SORT_STRING);

        return strtoupper(bin2hex(hash_hmac('sha1', implode('', $toSort), $appSecret, true)));
    }

    /**
     * 验签：忽略大小写比较。
     *
     * @param array<string, mixed> $params 含 _aop_signature 的参数集合
     */
    public static function verify(array $params, string $appSecret): bool
    {
        $clientSign = $params['_aop_signature'] ?? null;
        if (!is_string($clientSign) || $clientSign === '') {
            return false;
        }
        $serverSign = self::sign($params, $appSecret);

        return strcasecmp($serverSign, $clientSign) === 0;
    }

    /** 复杂值（数组/对象）序列化为 JSON 参与签名，标量直接转字符串 */
    private static function stringify($value): string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        return (string)$value;
    }
}
