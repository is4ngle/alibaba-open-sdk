<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Config;

use Is4ngle\AlibabaOpen\Exception\InvalidCredentialsException;

/**
 * 1688 开放平台凭证。
 *
 * access_token 的一期方案：假定外部已持有持久 token（静态传入或经 tokenProvider 惰性获取）。
 * tokenProvider 签名为 fn(): string，可接宿主应用的缓存/刷新逻辑（二期 OAuth 时替换实现即可）。
 */
final class Credentials
{
    private string $appKey;
    private string $appSecret;
    private ?string $accessToken;
    /** @var callable|null fn(): string */
    private $tokenProvider;

    public function __construct(
        string $appKey,
        string $appSecret,
        ?string $accessToken = null,
        ?callable $tokenProvider = null
    ) {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->accessToken = $accessToken;
        $this->tokenProvider = $tokenProvider;
    }

    public function getAppKey(): string
    {
        return $this->appKey;
    }

    public function getAppSecret(): string
    {
        return $this->appSecret;
    }

    /**
     * 惰性解析 token：优先显式 token，其次 tokenProvider；两者皆空抛异常。
     */
    public function getAccessToken(): string
    {
        if ($this->accessToken !== null && $this->accessToken !== '') {
            return $this->accessToken;
        }
        if ($this->tokenProvider !== null) {
            $token = ($this->tokenProvider)();
            if (is_string($token) && $token !== '') {
                return $token;
            }
        }
        throw new InvalidCredentialsException('access_token 未配置：请显式传入或提供 tokenProvider');
    }

    /** 是否已具备可用的 token（不触发 provider 调用失败的副作用语义，仅探测） */
    public function hasAccessToken(): bool
    {
        if ($this->accessToken !== null && $this->accessToken !== '') {
            return true;
        }
        if ($this->tokenProvider !== null) {
            try {
                return $this->getAccessToken() !== '';
            } catch (InvalidCredentialsException $e) {
                return false;
            }
        }
        return false;
    }

    /** 无状态衍生：返回一个带新 token 的凭证对象（tokenProvider 置空） */
    public function withAccessToken(string $accessToken): self
    {
        return new self($this->appKey, $this->appSecret, $accessToken, null);
    }
}
