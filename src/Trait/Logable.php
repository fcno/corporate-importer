<?php

namespace Fcno\CorporateImporter\Trait;

trait Logable
{
    /**
     * Nível do lo
     *
     * @var string
     */
    public $level = 'info';

    /**
     * Determina se deve-se logar o início e o fim do processo de importação.
     *
     * @return bool
     */
    public function shouldLog()
    {
        return config('corporateimporter.logging', false);
    }
}
