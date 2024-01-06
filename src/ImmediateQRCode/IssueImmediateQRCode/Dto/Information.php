<?php

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use JsonSerializable;

class Information implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly string $value
    ) {
    }

    public function toArray(): array
    {
        return [
            "nome" => $this->name,
            "valor" => $this->value
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
