<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Request;

/**
 * 业务 API 请求基类。
 *
 * 每个 API 一个子类（由 bin/generate.php 从官方 SDK 参数类生成，或手写），
 * 声明三元组（namespace/apiName/version）+ 公共 typed 属性（业务参数）。
 *
 * 两类形态：
 *  - 平铺型：属性即顶层 form 参数（toParams() 直接平铺）；
 *  - 包裹型：官方参数类为单字段包裹（如 param={"keywords":...} JSON 串），
 *    子类覆写 wrapKey() 返回包裹键，属性仍平铺书写，toParams() 自动包回。
 *
 * 嵌套/数组属性值由 Client 统一 json_encode 为字符串传输（与官方
 * Param2RequestSerializer 行为一致：顶层平铺 + 嵌套 JSON 串）。
 */
abstract class AbstractRequest
{
    abstract public function getNamespace(): string;

    abstract public function getApiName(): string;

    public function getVersion(): int
    {
        return 1;
    }

    /**
     * 包裹键：包裹型请求返回实际包裹字段名（如 'param'），平铺型返回 null。
     */
    protected function wrapKey(): ?string
    {
        return null;
    }

    /**
     * 序列化为网关 form 参数。
     *
     * 规则：null 与空串剔除（视为未设置）；布尔转 true/false 由 Client 处理；
     * 包裹型自动把全部字段包进 wrapKey 键。
     *
     * @return array<string, mixed>
     */
    public function toParams(): array
    {
        $params = [];
        foreach (get_object_vars($this) as $key => $value) {
            if ($value === null || $value === '' || $value === []) {
                continue;
            }
            $params[$key] = $value;
        }

        $wrapKey = $this->wrapKey();
        if ($wrapKey !== null) {
            return [$wrapKey => $params];
        }
        return $params;
    }

    /**
     * API 标识 "namespace:apiName-version"（调试展示用）。
     */
    public function toApiId(): string
    {
        return sprintf('%s:%s-%d', $this->getNamespace(), $this->getApiName(), $this->getVersion());
    }
}
