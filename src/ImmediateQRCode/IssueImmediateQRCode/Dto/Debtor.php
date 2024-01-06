<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use JsonSerializable;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\ItauIssueImmediateQRCodeException;

class Debtor implements JsonSerializable
{
    public function __construct(
        public readonly string $name,
        public readonly bool $isPf = false,
        public readonly string $cpf = '',
        public readonly string $cnpj = '',
    ) {
        if ($this->isPf && empty($this->cpf)) {
            throw new ItauIssueImmediateQRCodeException(
                code: 400,
                key: "devedor.cpf",
                description: "O campo CPF deve ser preenchido",
                responsePayload: []
            );
        }

        if (!$this->isPf && empty($this->cnpj)) {
            throw new ItauIssueImmediateQRCodeException(
                code: 400,
                key: "devedor.cnpj",
                description: "O campo CNPJ deve ser preenchido",
                responsePayload: []
            );
        }
    }

    public function toArray(): array
    {
        return array_filter([
            "nome" => $this->name,
            "cpf" => preg_replace('/[^0-9]/', '', $this->cpf),
            "cnpj" => preg_replace('/[^0-9]/', '', $this->cnpj)
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
