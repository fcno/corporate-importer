<?php

namespace Fcno\CorporateImporter;

use Fcno\CorporateImporter\Contracts\IImportable;
use Fcno\CorporateImporter\Exceptions\FileNotReadableException;
use Fcno\CorporateImporter\Importer\CargoImporter;
use Fcno\CorporateImporter\Importer\FuncaoImporter;
use Fcno\CorporateImporter\Importer\LotacaoImporter;
use Fcno\CorporateImporter\Importer\UsuarioImporter;
use Fcno\CorporateImporter\Trait\Logable;
use Illuminate\Support\Facades\Log;

/**
 * Importador da estrutura completa do arquivo corporativo.
 *
 * Importa, na sequência abaixo, as seguintes estruturas:
 * 1. Cargo
 * 2. Função
 * 3. Lotação
 * 4. Usuário
 */
class CorporateImporter implements IImportable
{
    use Logable;
    /**
     * Path completo para o arquivo XML com a estrutura corporativa que será
     * importado.
     *
     * @var string
     */
    protected $file_path;

    /**
     * {@inheritdoc}
     */
    public function from(string $file_path): static
    {
        $this->file_path = $file_path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): void
    {
        throw_if(! $this->isReadable($this->file_path), FileNotReadableException::class);

        $this
            ->start()
            ->import()
            ->finish();
    }

    /**
     * Verfica se o arquivo informado existe e pode ser lido.
     *
     * @param string $file_path full path
     *
     * @return bool
     */
    private function isReadable(string $file_path): bool
    {
        $response = is_readable($file_path);

        clearstatcache();

        return $response;
    }

    /**
     * Tratativas iniciais da importação.
     *
     * @return static
     */
    private function start(): static
    {
        if ($this->shouldLog()) {
            Log::log(
                level: $this->level,
                message: __('corporateimporter::corporateimporter.start'),
                context: [
                    'file_path' => $this->file_path,
                ]
            );
        }

        return $this;
    }

    /**
     * Aciona os importadores.
     *
     * @return static
     */
    private function import(): static
    {
        CargoImporter::make()
            ->from($this->file_path)
            ->run();
        FuncaoImporter::make()
            ->from($this->file_path)
            ->run();
        LotacaoImporter::make()
            ->from($this->file_path)
            ->run();
        UsuarioImporter::make()
            ->from($this->file_path)
            ->run();

        return $this;
    }

    /**
     * Tratativas finais da importação.
     *
     * @return static
     */
    private function finish(): static
    {
        if ($this->shouldLog()) {
            Log::log(
                level: $this->level,
                message: __('corporateimporter::corporateimporter.end'),
                context: [
                    'file_path' => $this->file_path,
                ]
            );
        }

        return $this;
    }
}
