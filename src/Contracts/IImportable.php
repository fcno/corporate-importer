<?php

namespace Fcno\CorporateImporter\Contracts;

interface IImportable
{
    /**
     * Full path do arquivo XML com a estrutura corporativa que será importado.
     *
     * @param string $file_path full path
     *
     * @return static
     */
    public function from(string $file_path): static;

    /**
     * Executa a importação.
     *
     * @throws \Fcno\CorporateImporter\Exceptions\FileNotReadableException
     *
     * @return void
     */
    public function execute(): void;
}
