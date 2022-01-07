<?php

namespace Fcno\CorporateImporter\Exceptions;

use Exception;

/**
 * Arquivo não pôde ser lido.
 *
 * @see https://laravel.com/docs/8.x/errors
 */
class FileNotReadableException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('corporateimporter::corporateimporter.filenotreadableexception'));
    }
}
