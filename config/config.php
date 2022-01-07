<?php

return [

    /**
     * ------------------------------------------------------------------------
     * Corporate Importer Logging
     * ------------------------------------------------------------------------
     *
     * Este package gera log para 04 cenários:
     * - Inicio da importação
     * - Fim da importação
     * - Falha na importação
     * - Inconsistências/falhas de validação nos dados
     *
     * Se habilitado, todos os cenários acima são registrados utilizando-se o
     * driver de log default da aplicação.
     * Isso é útil para monitor se o processo de importação está ocorrendo como
     * esperado.
     * Se desabilitado, não registrará log para os dois primeiros cenários,
     * mas continuará para os demais, visto que não afetadas por essa
     * configuração.
     */

    'logging' => true,

    /**
     * ------------------------------------------------------------------------
     * Max Upsert
     * ------------------------------------------------------------------------
     *
     * Quantidade padrão de objetos que serão persistidos no banco de dados por
     * query.
     *
     * Se menor ou igual a zero, o package assumirá o valor default definido no
     * código.
     */
    'maxupsert' => 500,
];
