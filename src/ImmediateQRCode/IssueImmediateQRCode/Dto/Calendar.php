<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use JsonSerializable;

class Calendar implements JsonSerializable
{
    public function __construct(
        public readonly int $expiration,
    ) {
    }

    public function toArray(): array
    {
        return array_filter(["expiracao" => $this->expiration]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
