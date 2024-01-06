<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau;

use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\IssueImmediateQRCode;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData as IssueImmediateQRCodeInput;

final class ItauGateway
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $apiKey,
        private readonly bool $isSandbox = false
    ) {
    }

    public function createImmediateQRCode(IssueImmediateQRCodeInput $inputData)
    {
        $immediateQRCode = new IssueImmediateQRCode(
            accessToken: $this->accessToken,
            apiKey: $this->apiKey,
            isSandbox: $this->isSandbox
        );
        return $immediateQRCode->issued($inputData)->toArray();
    }
}
