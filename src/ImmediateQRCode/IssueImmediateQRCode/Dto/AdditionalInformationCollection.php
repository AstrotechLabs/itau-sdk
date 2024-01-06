<?php

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
        $volumes = [];
        foreach ($items['items'] as $key => $item) {
            $volumes[$key] = $item->toArray();
        }
        return $volumes;
    }
}
