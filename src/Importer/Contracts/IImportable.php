<?php

namespace Fcno\CorporateImporter\Importer\Contracts;

interface IImportable
{
    /**
     * Full path do arquivo XML com a estrutura corporativa que será importado.
     *
     * @param string $file_path full path
     */
    public function from(string $file_path): static;

    /**
     * Executa a importação.
     */
    public function run(): void;
}
