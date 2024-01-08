<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau;

use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\IssueImmediateQRCode;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData;
use GuzzleHttp\Client;

final class ItauGateway
{
    private Client $httpClient;
    private array $headers;

    public function __construct(
        private readonly string $accessToken,
        private readonly string $apiKey,
        private readonly bool $isSandbox = false
    ) {
        $this->httpClient = new Client(
            [
                'base_uri' => $this->isSandbox ?
                    'https://sandbox.devportal.itau.com.br' :
                    'https://secure.api.itau'
            ]
        );

        $this->headers = [
            'x-itau-apikey' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->accessToken}"
        ];
    }

    public function createPixCharge(InputData $inputData)
    {
        $immediateQRCode = new IssueImmediateQRCode(
            httpClient: $this->httpClient,
            headers: $this->headers,
            isSandbox: $this->isSandbox
        );
        return $immediateQRCode->issued($inputData)->toArray();
    }
}
