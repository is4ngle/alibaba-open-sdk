<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Sign;

/**
 * 1688 AOP param2 规范签名器（网关请求签名）。
 *
 * 签名算法（与官方协议逐字节对齐，移植自 newton Java SDK AopSigner.java，与 liaosp/ali_open 的 PHP 实现交叉验证一致）：
 *  1. 参与签名的参数 = 业务参数 + 公共参数（access_token / _aop_datatype / _aop_timestamp），不含 _aop_signature；
 *  2. null 值参数一律跳过（与传输层"null 不写入 form"严格对齐，防止签出字面量 "null"）；
 *  3. 待签名串 = apiPath + 参数按 key 字典序（ksort）依次拼接 key+value（无分隔符）；
 *  4. HMAC-SHA1(appSecret)，输出大写十六进制串。
 *
 * 注意：apiPath 前缀为 "param2/{version}/{namespace}/{apiName}/{appKey}"，
 * 无 "/openapi" 前缀、无前导斜杠（与实际请求 URL 不同，这是网关签名约定的易错点）。
 *
 * 本类无状态、纯函数：相同输入恒得相同签名，可被黄金用例单测钉死。
 */
final class AopSigner
{
    /** 公共参数 _aop_datatype 固定值：application/json（非 "json"） */
    public const AOP_DATATYPE = 'application/json';

    /**
     * 组装 apiPath 前缀：param2/{version}/{namespace}/{apiName}/{appKey}（签名专用，无 /openapi 前缀）
     */
    public static function buildApiPath(string $namespace, string $apiName, string $appKey, int $version = 1): string
    {
        return sprintf('param2/%d/%s/%s/%s', $version, $namespace, $apiName, $appKey);
    }

    /**
     * 纯签名函数。
     *
     * @param array<string, string|null> $paramsWithoutSignature 参与签名的全部参数（业务 + 公共），不含 _aop_signature
     */
    public static function sign(string $apiPath, array $paramsWithoutSignature, string $appSecret): string
    {
        $sorted = [];
        foreach ($paramsWithoutSignature as $key => $value) {
            if ($value !== null) {
                $sorted[(string)$key] = (string)$value;
            }
        }
        ksort($sorted);

        $signStr = $apiPath;
        foreach ($sorted as $key => $value) {
            $signStr .= $key . $value;
        }

        return strtoupper(bin2hex(hash_hmac('sha1', $signStr, $appSecret, true)));
    }

    /**
     * 便捷方法：注入公共参数并签名，返回可直接作为 form body 的完整参数（含 _aop_signature）。
     *
     * @param array<string, string|null> $bizParams 业务参数（复杂参数须先 json_encode 为字符串）
     * @param string|null $accessToken 为 null 时不注入 access_token
     * @return array<string, string> 有序参数（含全部公共参数 + _aop_signature）
     */
    public static function signRequest(
        string $namespace,
        string $apiName,
        string $appKey,
        string $appSecret,
        ?string $accessToken,
        array $bizParams,
        string $timestampMillis,
        int $version = 1
    ): array {
        $all = [];
        foreach ($bizParams as $key => $value) {
            if ($value !== null) {
                $all[(string)$key] = (string)$value;
            }
        }
        if ($accessToken !== null && $accessToken !== '') {
            $all['access_token'] = $accessToken;
        }
        $all['_aop_datatype'] = self::AOP_DATATYPE;
        $all['_aop_timestamp'] = $timestampMillis;

        $apiPath = self::buildApiPath($namespace, $apiName, $appKey, $version);
        $all['_aop_signature'] = self::sign($apiPath, $all, $appSecret);

        return $all;
    }
}
