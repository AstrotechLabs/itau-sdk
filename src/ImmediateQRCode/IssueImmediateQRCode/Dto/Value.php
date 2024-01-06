<?php

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\ItauIssueImmediateQRCodeException;
use JsonSerializable;

class Value implements JsonSerializable
{
    public function __construct(
        public readonly float $original,
        public readonly int $changeModality = 0
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            "original" => $this->original,
            "modalidadeAlteracao" => $this->changeModality
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
