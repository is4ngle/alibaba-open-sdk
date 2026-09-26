<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Push\Callback;

use Is4ngle\AlibabaOpen\Exception\PushException;
use Is4ngle\AlibabaOpen\Push\PushMessage;
use Is4ngle\AlibabaOpen\Sign\CallbackSigner;

/**
 * HTTP 回调通道验签器（纯函数，不接触任何框架对象）。
 *
 * 宿主 controller 职责：把请求的 query 参数与 form/body 参数合并成一个数组传入即可。
 * 验签失败抛 PushException(SIGNATURE_MISMATCH)，宿主须返回 401（官方约定）。
 */
final class CallbackVerifier
{
    /**
     * 验签并解析为 PushMessage。
     *
     * @param array<string, mixed> $params 已合并 query+form 的原始参数数组（含 _aop_signature）
     * @throws PushException 验签失败 / 参数缺失
     */
    public static function parseAndVerify(array $params, string $appSecret): PushMessage
    {
        if (!isset($params['_aop_signature']) || !is_string($params['_aop_signature']) || $params['_aop_signature'] === '') {
            throw new PushException('回调缺少 _aop_signature 参数', PushException::CODE_MALFORMED_CALLBACK);
        }

        if (!CallbackSigner::verify($params, $appSecret)) {
            throw new PushException('回调验签失败', PushException::CODE_SIGNATURE_MISMATCH);
        }

        return self::parse($params);
    }

    /**
     * 仅解析不验签（已在外层验过签的场景，或测试构造用）。
     *
     * @param array<string, mixed> $params
     */
    public static function parse(array $params): PushMessage
    {
        $msgId = $params['msgId'] ?? null;
        if (!is_string($msgId) || $msgId === '') {
            throw new PushException('回调缺少 msgId 参数', PushException::CODE_MALFORMED_CALLBACK);
        }

        $data = $params['data'] ?? [];
        if (is_string($data) && $data !== '') {
            $decoded = json_decode($data, true);
            $data = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($data)) {
            $data = [];
        }

        $extraInfo = $params['extraInfo'] ?? [];
        if (is_string($extraInfo) && $extraInfo !== '') {
            $decoded = json_decode($extraInfo, true);
            $extraInfo = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($extraInfo)) {
            $extraInfo = [];
        }

        return new PushMessage(
            $msgId,
            (int)($params['gmtBorn'] ?? 0),
            $data,
            (string)($params['userInfo'] ?? ''),
            (string)($params['type'] ?? ''),
            isset($params['bizKey']) ? (string)$params['bizKey'] : null,
            $extraInfo
        );
    }

    /**
     * 构造一条带正确签名的回调参数集（模拟 1688 推送，调试/自测用）。
     *
     * @param array<string, mixed> $message
     * @return array<string, string> 含 _aop_signature 的参数集
     */
    public static function fakeSignedParams(array $message, string $appSecret): array
    {
        $params = [];
        foreach ($message as $key => $value) {
            $params[(string)$key] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string)$value;
        }
        $params['_aop_signature'] = CallbackSigner::sign($params, $appSecret);
        return $params;
    }
}
