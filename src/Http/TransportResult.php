<?php

declare(strict_types=1);

namespace Is4ngle\AlibabaOpen\Http;

/**
 * HTTP 传输结果（框架无关的值对象）
 */
final class TransportResult
{
    private int $status;
    private string $body;
    /** @var array<string, string> */
    private array $headers;

    /**
     * @param array<string, string> $headers
     */
    public function __construct(int $status, string $body, array $headers = [])
    {
        $this->status = $status;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /** @return array<string, string> */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function isSuccessful(): bool
    {
        return $this->status >= 200 && $this->status < 300;
    }
}
