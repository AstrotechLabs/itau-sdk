<?php

declare(strict_types=1);

namespace Tests\Integration\ImmediateQRCode;

use AstrotechLabs\Itau\ItauGateway;
use Tests\TestCase;
use Tests\Trait\HttpClientMock;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Loc;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Value;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Debtor;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Calendar;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Information;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\ItauIssueImmediateQRCodeException;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\AdditionalInformationCollection;

class IssueImmediateQRCodeTest extends TestCase
{
    use HttpClientMock;

    public function testReceivesQrCodeInfoWhenIssuingQrCodeWithMinimumFields()
    {
        $gateway = new ItauGateway(
            accessToken: $_ENV['ITAU_API_TOKEN'],
            apiKey: $_ENV['ITAU_API_KEY'],
            isSandbox: true
        );
        $valueInput = new Value(
            original: 200
        );
        $inputData = new InputData(
            value: $valueInput,
            pixKey: "60701190000104",
        );

        $response = $gateway->createPixCharge($inputData);

        $this->assertNotEmpty($response['txid']);
        $this->assertNotEmpty($response['status']);
        $this->assertEquals('ATIVA', $response['status']);
        $this->assertNotEmpty($response['pixKey']);
        $this->assertNotEmpty($response['pixCopyAndPaste']);
        $this->assertNotEmpty($response['value']);
    }

    public function testMustReceivesTheInformationAfterIssuingTheQrCodeWithAllFieldsFilledIn()
    {
        $gateway = new ItauGateway(
            accessToken: $_ENV['ITAU_API_TOKEN'],
            apiKey: $_ENV['ITAU_API_KEY'],
            isSandbox: true
        );
        $calendarInput = new Calendar(expiration: 3600);
        $debtorInput = new Debtor(
            name: "Corporação Capsula",
            cnpj: "60814824000127"
        );
        $locationInput = new Loc(
            id: 1234567890123456789
        );
        $valueInput = new Value(
            original: 200
        );
        $informationInput = new Information(
            name: "teste campo",
            value: "descrição opcional"
        );
        $additionalInformationInput = new AdditionalInformationCollection([
                $informationInput
            ]);
        $inputData = new InputData(
            calendar: $calendarInput,
            debtor: $debtorInput,
            location: $locationInput,
            value: $valueInput,
            pixKey: "60701190000104",
            payerRequest: "descrição do pagamento",
            additionalInformation: $additionalInformationInput
        );

        $response = $gateway->createPixCharge($inputData);

        $this->assertNotEmpty($response['txid']);
        $this->assertNotEmpty($response['status']);
        $this->assertEquals('ATIVA', $response['status']);
        $this->assertNotEmpty($response['pixKey']);
        $this->assertNotEmpty($response['pixCopyAndPaste']);
        $this->assertNotEmpty($response['value']);
    }

    public function testReceivesAnErrorWhenThePixKeyIsIncorrect()
    {
        $this->expectException(ItauIssueImmediateQRCodeException::class);
        $this->expectExceptionMessage('O campo cob.chave não respeita o schema.');
        $this->expectExceptionCode(400);

        $gateway = new ItauGateway(
            accessToken: $_ENV['ITAU_API_TOKEN'],
            apiKey: $_ENV['ITAU_API_KEY'],
            isSandbox: true
        );

        $valueInput = new Value(
            original: 200
        );
        $inputData = new InputData(
            value: $valueInput,
            pixKey: "60701190000104",
        );

        $gateway->createPixCharge($inputData);
    }

    public function testReceivesAnErrorWhenTheTokenIsInvalid()
    {
        $this->expectException(ItauIssueImmediateQRCodeException::class);
        $this->expectExceptionMessage('Access Denied');
        $this->expectExceptionCode(403);

        $gateway = new ItauGateway(
            accessToken: $_ENV['ITAU_API_TOKEN'],
            apiKey: $_ENV['ITAU_API_KEY'],
            isSandbox: true
        );

        $valueInput = new Value(
            original: 200
        );
        $inputData = new InputData(
            value: $valueInput,
            pixKey: "60701190000104",
        );

        $gateway->createPixCharge($inputData);
    }
}
