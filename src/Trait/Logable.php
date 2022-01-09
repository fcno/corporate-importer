<?php

namespace Fcno\CorporateImporter\Trait;

trait Logable
{
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
