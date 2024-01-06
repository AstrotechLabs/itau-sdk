<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode;

use Exception;

class ItauIssueImmediateQRCodeException extends Exception
{
    private string $key;
    private string $description;
    private ?array $responsePayload;

    public function __construct(int $code, string $key, string $description, ?array $responsePayload)
    {
        $this->code = $code;
        $this->key = $key;
        $this->description = $description;
        $this->responsePayload = $responsePayload;
        parent::__construct("[error: $key] - {$description}");
    }

    public function getResponsePayload(): ?array
    {
        return $this->responsePayload;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
