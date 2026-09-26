<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Config;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * 运行选项（网关地址、超时、限流重试参数、日志）。
 */
final class Options
{
    public const DEFAULT_GATEWAY_URL = 'https://gw.open.1688.com';

    private string $gatewayUrl;
    private float $timeout;
    private float $connectTimeout;
    private int $maxRetries;
    private int $baseDelayMs;
    private int $maxDelayMs;
    private LoggerInterface $logger;

    public function __construct(
        string $gatewayUrl = self::DEFAULT_GATEWAY_URL,
        float $timeout = 10.0,
        float $connectTimeout = 5.0,
        int $maxRetries = 3,
        int $baseDelayMs = 200,
        int $maxDelayMs = 5000,
        ?LoggerInterface $logger = null
    ) {
        $this->gatewayUrl = rtrim($gatewayUrl, '/');
        $this->timeout = $timeout;
        $this->connectTimeout = $connectTimeout;
        $this->maxRetries = $maxRetries;
        $this->baseDelayMs = $baseDelayMs;
        $this->maxDelayMs = $maxDelayMs;
        $this->logger = $logger ?? new NullLogger();
    }

    public function getGatewayUrl(): string
    {
        return $this->gatewayUrl;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }

    public function getMaxRetries(): int
    {
        return $this->maxRetries;
    }

    public function getBaseDelayMs(): int
    {
        return $this->baseDelayMs;
    }

    public function getMaxDelayMs(): int
    {
        return $this->maxDelayMs;
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public static function fromArray(array $config): self
    {
        return new self(
            (string)($config['gateway_url'] ?? self::DEFAULT_GATEWAY_URL),
            (float)($config['timeout'] ?? 10.0),
            (float)($config['connect_timeout'] ?? 5.0),
            (int)($config['max_retries'] ?? 3),
            (int)($config['base_delay_ms'] ?? 200),
            (int)($config['max_delay_ms'] ?? 5000),
            $config['logger'] ?? null
        );
    }
}
