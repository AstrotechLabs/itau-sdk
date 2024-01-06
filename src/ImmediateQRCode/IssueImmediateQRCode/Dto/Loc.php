<?php

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\ItauIssueImmediateQRCodeException;
use JsonSerializable;

class Loc implements JsonSerializable
{
    public function __construct(
        public readonly int $id
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
