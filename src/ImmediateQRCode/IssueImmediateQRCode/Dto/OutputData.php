<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use JsonSerializable;

class OutputData implements JsonSerializable
{
    public function __construct(
        public readonly string $txid,
        public readonly string $status,
        public readonly string $pixKey,
        public readonly string $pixCopyAndPaste,
        public readonly float $value,
        public readonly array $payloadDetails,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
