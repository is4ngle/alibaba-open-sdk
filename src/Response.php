<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen;

/**
 * 网关响应统一封装。
 *
 * 错误分层约定：
 *  - 网关级错误（HTTP 非 2xx / 非 JSON / gw.* 前缀 error_code）在 Client 中已抛 GatewayException，不会到达本类；
 *  - 业务级失败（error_code 不带 gw. 前缀）不抛异常，由 isSuccess() === false 表达，getRaw() 永远可取原始数据兜底。
 *
 * result 剥壳（1688 各 API 响应结构不对称：有的顶层平铺、有的包一层 result）：
 *  - UNWRAP_AUTO：顶层存在 result 键且值为数组时剥之（默认，通用入口使用）；
 *  - UNWRAP_ALWAYS：强制按 result 壳处理（联调确认包壳的 API 显式指定）；
 *  - UNWRAP_NEVER：不剥（联调确认平铺的 API 显式指定）。
 * 业务封装层应按 API 显式指定剥壳模式，AUTO 仅作兜底。
 */
final class Response
{
    public const UNWRAP_AUTO = 'auto';
    public const UNWRAP_ALWAYS = 'always';
    public const UNWRAP_NEVER = 'never';

    /** @var array<string, mixed> */
    private array $raw;
    /** @var array<string, mixed>|null */
    private ?array $data;
    /** 剥壳模式是否已解析（区分"未剥壳"与"剥壳后为 null"两种状态） */
    private bool $dataResolved;

    /**
     * @param array<string, mixed> $raw 网关返回的原始解码数组
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->data = null;
        $this->dataResolved = false;
    }

    /** @return array<string, mixed> 原始解码数组（永远兜底） */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * 返回指定剥壳模式下的视图（不影响本对象）。
     */
    public function unwrap(string $mode = self::UNWRAP_AUTO): self
    {
        $view = new self($this->raw);
        $view->data = $this->unwrapData($mode);
        $view->dataResolved = true;
        return $view;
    }

    /** @return array<string, mixed>|null 剥壳后的业务数据（该 API 无 result 壳/显式不剥时为 null，请配合 getRaw()） */
    public function getData(): ?array
    {
        if (!$this->dataResolved) {
            $this->data = $this->unwrapData(self::UNWRAP_AUTO);
            $this->dataResolved = true;
        }
        return $this->data;
    }

    /**
     * 业务成功判定：无 error_code 且无 error_message/errorMessage/message 错误字段。
     * （部分 API 成功响应也会带 message 字段，联调确认后可在业务封装层覆盖判定逻辑。）
     */
    public function isSuccess(): bool
    {
        // 1688 代发系 API 的统一包裹结构：{result, success, errorCode, errorMsg}
        if (array_key_exists('success', $this->raw) && $this->raw['success'] === false) {
            return false;
        }
        foreach (['errorCode', 'errorMsg'] as $key) {
            if (isset($this->raw[$key]) && $this->raw[$key] !== '') {
                return false;
            }
        }
        if (isset($this->raw['error_code']) && $this->raw['error_code'] !== '') {
            return false;
        }
        foreach (['error_message', 'errorMessage'] as $key) {
            if (isset($this->raw[$key]) && $this->raw[$key] !== '') {
                return false;
            }
        }
        return true;
    }

    /**
     * 业务结果：剥掉 result 壳（代发包统一 {result, success, errorCode, errorMsg} 包裹）。
     *
     * @return array<string, mixed>|null 无 result 壳或非数组时返回 null（用 getRaw() 兜底）
     */
    public function result(): ?array
    {
        return $this->unwrapData(self::UNWRAP_ALWAYS);
    }

    /** 业务级错误码（网关级错误已抛异常，不会到达这里） */
    public function getErrorCode(): ?string
    {
        $code = $this->raw['error_code'] ?? ($this->raw['errorCode'] ?? null);
        return $code !== null && $code !== '' ? (string)$code : null;
    }

    /** 业务级错误消息：error_message | errorMessage | errorMsg | message 兜底 */
    public function getErrorMessage(): ?string
    {
        foreach (['error_message', 'errorMessage', 'errorMsg', 'message'] as $key) {
            if (isset($this->raw[$key]) && $this->raw[$key] !== '') {
                return (string)$this->raw[$key];
            }
        }
        return null;
    }

    public function getEagleTraceId(): ?string
    {
        $id = $this->raw['eagleTraceId'] ?? null;
        return $id !== null && $id !== '' ? (string)$id : null;
    }

    /** @return array<string, mixed>|null */
    private function unwrapData(string $mode): ?array
    {
        if ($mode === self::UNWRAP_NEVER) {
            return null;
        }
        if ($mode === self::UNWRAP_ALWAYS) {
            $result = $this->raw['result'] ?? null;
            return is_array($result) ? $result : null;
        }
        // AUTO：顶层存在唯一 result 键且值为数组时剥之
        if (array_key_exists('result', $this->raw) && is_array($this->raw['result'])) {
            return $this->raw['result'];
        }
        return null;
    }
}
