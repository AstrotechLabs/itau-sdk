# Itaú SDK para PHP

Este é um repositório que possui uma abstração a API do Itaú V2, auxiliando na criação de QR Code Imediato e a 
configuração do seu webhook para notificação de pagamentos e muito mais.


## Instalação
A forma mais recomendada de instalar este pacote é através do [composer](http://getcomposer.org/download/).

Para instalar, basta executar o comando abaixo

```bash
@todo
```

ou adicionar esse linha

```
@todo
```

na seção `require` do seu arquivo `composer.json`.

## Como Usar ?
## Criação de QRCode Imediato
Com o código abaixo você consegue emitir um QR Code imediato, neste caso o Itaú fica responsável 
por gerar o identificador da movimentação (txid).

Exemplo Simples com o mínimo de informação passada ao SDK
```php
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\InputData;
use AstrotechLabs\Itau\ImmediateQRCode\IssueImmediateQRCode\Dto\Value;
use AstrotechLabs\Itau\ItauGateway;

$itauGateway = new ItauGateway(
    accessToken: "token",
    apiKey: "e3c3ec92-4bf6-417a-a4f8-1c828e79se2901",
//    isSandbox: true (Optional)
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
```
Saída

``` 
[
    [txid] => bbba96adf0e442a0802761bb2758d9e5
    [status] => ATIVA
    [pixKey] => 60701190000104
    [pixCopyAndPaste] => 00020101021226910014BR.GOV.BCB.PIX2569spi-h.itau.com.br/pix/qr/v2/af581bdc-624e-4333-af38-1adaddfa6ce05204000053039865802BR5914PMD BASHAR RIO6009SAO PAULO62070503***6304E7DB
    [value] => 200
    [payloadDetails] => [
            [calendario] => [
                    [criacao] => 2024-01-06T00:27:30.95Z
                    [expiracao] => 86400
                ]
            [txid] => bbba96adf0e442a0802761bb2758d9e5
            [revisao] => 0
            [loc] => [
                    [id] => 789
                    [criacao] => 2024-01-06T00:27:30.95Z
                    [location] => spi-h.itau.com.br/pix/qr/v2/af581bdc-624e-4333-af38-1adaddfa6ce0
                    [tipoCob] => cob
                ]
            [location] => spi-h.itau.com.br/pix/qr/v2/af581bdc-624e-4333-af38-1adaddfa6ce0
            [status] => ATIVA
            [devedor] => [
                    [cnpj] => 12345678000195
                    [nome] => EMPRESA DE SERVIÇOS SA
                ]
            [valor] => [
                    [original] => 200
                    [modalidadeAlteracao] => 0
                ]
            [pixCopiaECola] => 00020101021226910014BR.GOV.BCB.PIX2569spi-h.itau.com.br/pix/qr/v2/af581bdc-624e-4333-af38-1adaddfa6ce05204000053039865802BR5914PMD BASHAR RIO6009SAO PAULO62070503***6304E7DB
            [chave] => 60701190000104
        ]
]
```