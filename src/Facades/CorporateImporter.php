<?php

namespace Fcno\CorporateImporter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fcno\CorporateImporter\CorporateImporter
 * @see https://laravel.com/docs/8.x/facades
 */
class CorporateImporter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'corporate-importer';
    }
}
