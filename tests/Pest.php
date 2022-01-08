<?php

use Fcno\CorporateImporter\Tests\TestCase;
use Illuminate\Support\Facades\Storage;

uses(TestCase::class)->in('Feature', 'Unit');

uses()
->beforeEach(function () {
    $this->file_system = Storage::fake('corporativo', [
        'driver' => 'local',
    ]);

    // load do template do arquivo corporativo
    $xmlstr = require __DIR__ . '/template/Corporate.php';

    $this->file_name = 'corporativo.xml';

    // cria o arquivo corporativo no File System
    (new \SimpleXMLElement($xmlstr))
    ->asXML(
        $this->file_system->path($this->file_name)
    );
})->in('Feature/CargoImporter');
