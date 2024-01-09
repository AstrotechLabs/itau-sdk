<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto;

use AstrotechLabs\Itau\Shared\Utils\CollectionBase;

class AdditionalInformationCollection extends CollectionBase
{
    protected function className(): string
    {
        return Information::class;
    }

    public function toArray(): array
    {
        $items = get_object_vars($this);
        $informations = [];
        foreach ($items['items'] as $key => $item) {
            $informations[$key] = $item->toArray();
        }
        return $informations;
    }
}
