<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Sign;

/**
 * WebSocket 通道 CONNECT / HEARTBEAT 帧签名器。
 *
 * 签名算法（移植自官方 tuna SDK ClientUtils.sign）：
 *   待签名串 = secret + appKey + [content] + pubTime
 *   （content 为 null 或空串时跳过；pubTime 为毫秒时间戳）
 *   MD5 后输出大写十六进制串。
 *
 * 本类无状态、纯函数。
 */
final class HeartbeatSigner
{
    /**
     * @param int|null $pubTime 毫秒时间戳
     */
    public static function sign(
        string $appKey,
        string $appSecret,
        ?string $content = null,
        ?int $pubTime = null
    ): string {
        $str = $appSecret;
        if ($appKey !== '') {
            $str .= $appKey;
        }
        if ($content !== null && $content !== '') {
            $str .= $content;
        }
        if ($pubTime !== null && (string)$pubTime !== '') {
            $str .= (string)$pubTime;
        }

        return strtoupper(bin2hex(md5($str, true)));
    }
}
