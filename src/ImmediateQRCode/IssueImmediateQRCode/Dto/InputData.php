<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use JsonSerializable;

class InputData implements JsonSerializable
{
    public function __construct(
        public readonly Value $value,
        public readonly string $pixKey,
        public readonly Calendar|null $calendar = null,
        public readonly Debtor|null $debtor = null,
        public readonly Loc|null $location = null,
        public readonly string|null $payerRequest = null,
        public readonly AdditionalInformationCollection|null $additionalInformation = null
    ) {
    }
    public function toArray(): array
    {
        return array_filter([
            "calendario" => $this->calendar?->toArray(),
            "devedor" => $this->debtor?->toArray(),
            "loc" => $this->location?->toArray(),
            "valor" => $this->value->toArray(),
            "chave" => $this->pixKey,
            "solicitacaoPagador" => $this->payerRequest,
            "infoAdicionais" => $this->additionalInformation?->toArray()
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
