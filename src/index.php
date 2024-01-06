<?php


declare(strict_types=1);

use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Value;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData;

error_reporting(E_ALL & ~E_DEPRECATED);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();

DG\BypassFinals::enable();


$itauGateway = new \AstrotechLabs\Itau\ItauGateway(
    accessToken: "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI0NTE2ZGI1NC1iZmJjLTMwMjctOTQ2OC02NTZmMGU3MjA3Y2IiLCJleHAiOjE3MDQ1MDExMTksImlhdCI6MTcwNDUwMDgxOSwic291cmNlIjoic3RzLXNhbmRib3giLCJlbnYiOiJQIiwiZmxvdyI6IkNDIiwic2NvcGUiOiJwaXhfcmVjZWJpbWVudG9zX2V4dF92Mi1zY29wZSJ9.5zs_FUZAtx3AL1xRgAT-_0C91TQ5dvOn_oZNNmXt4LA",
    apiKey: "e3c3ec92-4bf6-417a-a4f8-1c828e796709",
    isSandbox: true
);
$valueInput = new Value(
    original: 200
);
$inputData = new InputData(
    value: $valueInput,
    pixKey: "60701190000104",
);
$response = $itauGateway->createImmediateQRCode($inputData);

print_r($response);
