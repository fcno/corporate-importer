# Corporate Importer para aplicações Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fcno/corporate-importer.svg?style=flat-square)](https://packagist.org/packages/fcno/corporate-importer)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fcno/corporate-importer/run-tests?label=tests)](https://github.com/fcno/corporate-importer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/fcno/corporate-importer/Check%20&%20fix%20styling?label=code%20style)](https://github.com/fcno/corporate-importer/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fcno/corporate-importer.svg?style=flat-square)](https://packagist.org/packages/fcno/corporate-importer)

Package para importar a estrutura corporativa em formato XML para aplicações **[Laravel](https://laravel.com/docs)**.

Este package foi planejado de acordo com as necessidades da Justiça Federal da 2ª Região. Contudo, ele pode ser utilizado em outros órgãos e projetos observado os termos previstos no [licenciamento](#licença).

```php
use Fcno\CorporateImporter\Facades\CorporateImporter;

CorporateImporter::from($file_path)->run();
```

&nbsp;

---

## Conteúdo

1. [Notas](#notas)

2. [Pré-requisitos](#pré-requisitos)

3. [Instalação](#instalação)

4. [Como funciona](#como-funciona)

5. [Testes e Integração Contínua](#testes-e-integração-contínua)

6. [Changelog](#changelog)

7. [Contribuição](#contribuição)

8. [Código de Conduta](#código-de-conduta)

9. [Vulnerabilidades de Segurança](#vulnerabilidades-de-segurança)

10. [Suporte e Atualizações](#suporte-e-atualizações)

11. [Créditos](#créditos)

12. [Agradecimentos](#agradecimentos)

13. [Licença](#licença)

---

## Notas

⭐ Estrutura corporativa é o nome dado à consolidação das informações mínimas sobre pessoal, cargos, funções de confiança e lotações.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Pré-requisitos

1. Dependências PHP

    PHP ^8.0

    [Extensões](https://getcomposer.org/doc/03-cli.md#check-platform-reqs)

    ```bash
    composer check-platform-reqs
    ```

2. [GitHub Package Dependencies](/../../network/dependencies)

⬆️ [Voltar](#conteúdo)

&nbsp;

## Instalação

1. Instalar via **[composer](https://getcomposer.org/)**:

    ```bash
    composer require fcno/corporate-importer
    ```

2. Publicar as migrations necessárias

    ```bash
    php artisan fcno:corporate-importer --tag=migrations
    ```

3. Opcionalmente publicar as configurações

    ```bash
    php artisan fcno:corporate-importer --tag=config
    ```

4. Opcionalmente alterar as mensagens ou criar outras traduções

    Crie a seguinte estrutura de pastas em seu projeto

    ```bash
    /resources
        /lang
            /vendor
                /ldap
                    /pt-br
                        corporateimporter.php
    ```

    Caso necessário, altere a pasta **pt-br** para o idioma definido na aplicação, ex: **en**, **es** etc

    As strings disponíveis para tradução são as que seguem. Altere-as de acordo com a necessidade.

    ```php
    <?php

    return [
        'end' => 'Fim da importação da estrutura corporativa',
        'filenotreadableexception' => 'O arquivo informado não pôde ser lido!',
        'start' => 'Início da importação da estrutura corporativa',
        'validation' => 'Validação falhou!',
    ];
    ```

    &nbsp;

⬆️ [Voltar](#conteúdo)

&nbsp;

## Como funciona

Gerar o arquivo corporativo em formato XML:

```xml
<?xml version='1.0' encoding='UTF-8'?>
<base>
    <cargos>
        <!-- Cargos:
            id: integer, obrigatório e maior que 1
            nome: string, obrigatório e tamanho entre 1 e 255
            -->
        <cargo id="1" nome="Cargo 1"/>
        <cargo id="2" nome="Cargo 2"/>
    </cargos>
    <funcoes>
        <!-- Funções:
            id: integer, obrigatório e maior que 1
            nome: string, obrigatório e tamanho entre 1 e 255
            -->
        <funcao id="1" nome="Função 1"/>
        <funcao id="2" nome="Função 2"/>
    </funcoes>
    <lotacoes>
        <!-- Lotações:
            id: integer, obrigatório e maior que 1
            nome: string, obrigatório e tamanho entre 1 e 255
            sigla: string, obrigatório e tamanho entre 1 e 50
            idPai: integer, opcional, id de uma lotação existente
            -->
        <lotacao id="1" nome="Lotação 1" sigla="Sigla 1"/>
        <lotacao id="2" nome="Lotação 2" sigla="Sigla 2" idPai=""/>
        <lotacao id="3" nome="Lotação 3" sigla="Sigla 3" idPai="1"/>
    </lotacoes>
    <pessoas>
        <!-- Lotações:
            nome: string, obrigatório e tamanho entre 1 e 255
            sigla: string, obrigatório (preferencialmente o usuário do LDAP Server) e tamanho entre 1 e 20
            cargo: integer, obrigatório, id de um cargo existente
            lotacao: integer, obrigatório, id de uma lotação existente
            funcaoConfianca: integer, opcional, id de uma função de confiança existente
            -->
        <pessoa id="1" nome="Pessoa 1" sigla="Sigla 1" cargo="1" lotacao="2" funcaoConfianca=""/>
        <pessoa id="2" nome="Pessoa 2" sigla="Sigla 2" cargo="1" lotacao="2" funcaoConfianca="2"/>
    </pessoas>
</base>
```

&nbsp;

Para realizar a importação, são expostos os seguintes métodos:

&nbsp;

✏️ **from**

Assinatura e uso: definir o caminho completo para o arquivo XML com a estrutura corporativa

```php
use Fcno\CorporateImporter\Facades\CorporateImporter;

/**
 * @param string $file_path full path para o arquivo
 * 
 * @return static
 */
CorporateImporter::from($file_path);
```

Retorno: Instância da classe **CorporateImporter**

&nbsp;

✏️ **run**

Assinatura e uso: Importa a estrutura definida no arquivo informado

```php
use Fcno\CorporateImporter\Facades\CorporateImporter;

/**
 * @throws \Fcno\CorporateImporter\Exceptions\FileNotReadableException
 *
 * @return void
*/
CorporateImporter::from($file_path)->run();
```

Retorno: void

&nbsp;

🚨 **Exceptions**:

- **run** lança **\Fcno\CorporateImporter\Exceptions\FileNotReadableException** caso não tenha permissão de leitura no arquivo ou ele não seja encontrado

⬆️ [Voltar](#conteúdo)

&nbsp;

## Testes e Integração Contínua

```bash
composer analyse
composer test
composer coverage
```

⬆️ [Voltar](#conteúdo)

&nbsp;

## Changelog

Por favor, veja o [CHANGELOG](CHANGELOG.md) para maiores informações sobre o que mudou em cada versão.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Contribuição

Por favor, veja [CONTRIBUTING](.github/CONTRIBUTING.md) para maiores detalhes.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Código de Conduta

Para garantir que todos sejam bem vindos a contribuir com esse projeto open-source, por favor leia e siga o [Código de Conduta](.github/CODE_OF_CONDUCT.md).

⬆️ [Back](#conteúdo)

&nbsp;

## Vulnerabilidades de Segurança

Por favor, veja na [política de segurança](/../../security/policy) como reportar vulnerabilidades ou falhas de segurança.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Suporte e Atualizações

A versão mais recente receberá suporte e atualizações sempre que houver necessidade. As demais receberão apenas atualizações para corrigir [vulnerabilidades de segurança](#vulnerabilidades-de-segurança) por até 06 meses após ela ter sido substituída por uma nova versão.

🐛 Encontrou um bug?!?! Abra um **[issue](/../../issues/new?assignees=fcno&labels=bug%2Ctriage&template=bug_report.yml&title=%5BA+concise+title+for+the+bug%5D)**.

✨ Alguma ideia nova?!?! Inicie **[uma discussão](/../../discussions/new?category=ideas)**.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Créditos

- [Fábio Cassiano](https://github.com/fcno)

- [All Contributors](/../../contributors)

⬆️ [Voltar](#conteúdo)

&nbsp;

## Agradecimentos

👋 Agradeço às pessoas e organizações abaixo por terem doado seu tempo na construção de projetos open-source que foram usados neste package.

- ❤️ [Laravel](https://github.com/laravel) pelos packages:

  - [illuminate/collections](https://github.com/illuminate/collections)

  - [illuminate/contracts](https://github.com/illuminate/contracts)

  - [illuminate/filesystem](https://github.com/illuminate/filesystem)

  - [illuminate/support](https://github.com/illuminate/support)

- ❤️ [Orchestra Platform](https://github.com/orchestral) pelo package [orchestral/testbench](https://github.com/orchestral/testbench)

- ❤️ [FriendsOfPHP](https://github.com/FriendsOfPHP) pelos package [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

- ❤️ [Nuno Maduro](https://github.com/nunomaduro) pelos package [nunomaduro/larastan](https://github.com/nunomaduro/larastan)

- ❤️ [PEST](https://github.com/pestphp) pelos packages:

  - [pestphp/pest](https://github.com/pestphp/pest)

  - [pestphp/pest-plugin-laravel](https://github.com/pestphp/pest-plugin-laravel)

- ❤️ [Sebastian Bergmann](https://github.com/sebastianbergmann) pelo package [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit)

- ❤️ [PHPStan](https://github.com/phpstan) pelos packages:

  - [phpstan/phpstan](https://github.com/phpstan/phpstan)

  - [phpstan/phpstan-deprecation-rules](https://github.com/phpstan/phpstan-deprecation-rules)

  - [phpstan/phpstan-phpunit](https://github.com/phpstan/phpstan-phpunit)

💸 Algumas dessas pessoas ou organizações possuem alguns produtos/serviços que podem ser comprados. Se você puder ajudá-los comprando algum deles ou se tornando um patrocinador, mesmo que por curto período, ajudará toda a comunidade **open-source** a continuar desenvolvendo soluções para todos.

⬆️ [Voltar](#conteúdo)

&nbsp;

## Licença

The MIT License (MIT). Por favor, veja o **[License File](LICENSE.md)** para maiores informações.

⬆️ [Voltar](#conteúdo)
