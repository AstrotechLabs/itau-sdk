<?php

declare(strict_types=1);

namespace AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\OutputData;

final class IssueImmediateQRCode
{
    public function __construct(
        private readonly Client $httpClient,
        private readonly array $headers,
        private readonly bool $isSandbox = false
    ) {
    }

    public function issued(InputData $input): OutputData
    {

        $uri = $this->isSandbox ? "/itau-ep9-gtw-pix-recebimentos-ext-v2/v2/cob" : "/pix_recebimentos/v2/cob";

        try {
            $response = $this->httpClient->post(uri:$uri, options:[
                'headers' => $this->headers,
                'json' => $input->toArray()
            ]);

            $responsePayload = json_decode($response->getBody()->getContents(), true);
        } catch (
            ClientException
            | ServerException
            $e
        ) {
            $responsePayload = json_decode($e->getResponse()->getBody()->getContents(), true);
            $data = isset($responsePayload['violacoes']) ? current($responsePayload['violacoes']) : '';
            $key =  'Request';
            $description = $responsePayload['message'] ?? 'Request Error';

            if (is_array($data)) {
                $key = $data['propriedade'];
                $description = $data['razao'];
            }


            throw new ItauIssueImmediateQRCodeException(
                code: $e->getCode(),
                key:$key,
                description: $description,
                responsePayload: [],
            );
        }

        return new OutputData(
            txid: $responsePayload['txid'],
            status:  $responsePayload['status'],
            pixKey: $responsePayload['chave'],
            pixCopyAndPaste: $responsePayload['pixCopiaECola'],
            value: (float)$responsePayload['valor']['original'],
            payloadDetails: $responsePayload
        );
    }

}
