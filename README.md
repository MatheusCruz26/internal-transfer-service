# Transaction service

Olá, esse serviço simula transações entre clientes e lojistas. Seja bem-vindo(a) !!

## Objetivo

Temos 2 tipos de usuários, os clientes e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles.

Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

- Clientes podem enviar dinheiro (efetuar transferência) para lojistas e entre clientes. 

- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo.

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia. 

- No recebimento de pagamento, o cliente ou lojista precisa receber notificação enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável.

- Este serviço deve ser RESTFul.

## Payload

POST /transaction

```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```

## Setup

-   PHP 7.3
-   Mysql 5.7
-   Lumen versão 8.2.3 / Laravel Components ^8.0
-   Nginx

## Dependências

-   Docker

## Execução do projeto

### Execute o arquivo `Makefile` na raiz do projeto

`make init`

Este comando irá executar os seguintes passos:

1. Criar o arquivo .env com base no .env-example
2. Subir os containers Docker em sua máquina
3. Instalação das dependências
4. Execução das Migrations
5. Execução das Seeds
6. Execução dos testes
7. Iniciar o processamento dos Jobs

Após esses passos o ambiente poderá ser acessado através da url: **http://localhost:8000**

## Backlog

-   Bloquear transações iguais num curto periodo de tempo
-   Enviar um e-mail com o comprovante da transação para o lojista e cliente
-   Notificar o pagador que ocorreu um problema em sua transação
-   Utilizar uma chave mais segura para identificar o pagador e o beneficiário
-   Criar serviço de clientes