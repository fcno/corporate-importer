<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Exceptions\FileNotReadableException;
use Fcno\CorporateImporter\Importer\Contracts\IImportable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

abstract class BaseImporter implements IImportable
{
    /**
     * Regras que serão aplicadas a cada campo do nó XML que será importado.
     *
     * @var array<string, mixed[]> assoc array
     */
    protected $rules;

    /**
     * Nome do nó XML que será importado.
     *
     * @var string
     */
    protected $node;

    /**
     * Atributos (campos) para se considerar o objeto único no banco de dados.
     *
     * @var string[]
     */
    protected $unique;

    /**
     * Atributos (campos) que devem ser atualizados no banco de dados se o
     * objeto já estiver persistido.
     *
     * @var string[]
     */
    protected $fields_to_update;

    /**
     * Path completo para o arquivo XML com a estrutura corporativa que será
     * importado.
     *
     * @var string
     */
    protected $file_path;

    /**
     * Quantidade de registros que será inserida/atualizada em uma única query.
     *
     * @var int
     */
    protected $max_upsert = 500;

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

        $this->setup();
        $this->process();
    }

    /**
     * Tratativas iniciais para a importação.
     */
    protected function setup(): void
    {
        $max = config('corporateimporter.maxupsert');

        if (is_int($max) && $max >= 1) {
            $this->max_upsert = $max;
        }
    }

    /**
     * Extrai do nó XML os campos de interesse para o objeto.
     *
     * O array conterá os campos de interesse (key), e os respectivos valores
     * (value) extraídos do nó xml informado.
     *
     * Ex.: [
     *     'id' => '10',
     *     'nome' => 'Fábio Cassiano',
     * ]
     *
     * @param \XMLReader $node nó de onde serão extraídos os valores
     *
     * @return array<string, string> array assoc
     */
    abstract protected function extractFieldsFromNode(\XMLReader $node): array;

    /**
     * Faz a persistência dos itens validados.
     */
    abstract protected function save(Collection $validated): void;

    /**
     * Prepara a entidade para persistência.
     *
     * A preparação é feita por meio dos seguintes passos:
     * - Ler o arquivo;
     * - Extrair os dados do nó xml de interesse;
     * - Validar os dados extraídos e, se preciso, logar as inconsistências;
     * - Acionar a persistência.
     *
     * @see https://drib.tech/programming/parse-large-xml-files-php
     */
    protected function process(): void
    {
        $validated = collect();
        $xml = new \XMLReader();
        $xml->open($this->file_path);

        // finding first primary element to work with
        while ($xml->read() && $xml->name != $this->node) {
        }

        // looping through elements
        while ($xml->name == $this->node) {
            $input = $this->extractFieldsFromNode($xml);

            $valid = $this->validateAndLogError($input);

            if ($valid) {
                $validated->push($valid);
            }

            // salva a quantidade determinada de registros por vez
            if ($validated->count() >= $this->max_upsert) {
                $this->save($validated);
                $validated = collect();
            }

            // moving pointer
            $xml->next($this->node);
        }

        $xml->close();

        // salva o saldo dos registros
        if ($validated->isNotEmpty()) {
            $this->save($validated);
        }
    }

    /**
     * Retorna os inputs válidos de acordo com as rules de importação.
     *
     * Em caso de falha de validação, retorna null e loga as falhas.
     *
     * @param array<string, string> $inputs assoc array
     *
     * @return array<string, string>|null assoc array
     */
    private function validateAndLogError(array $inputs): ?array
    {
        $validator = Validator::make($inputs, $this->rules);

        if ($validator->fails()) {
            $this->log(
                'warning',
                __('corporateimporter::corporateimporter.validation'),
                [
                    'input' => $inputs,
                    'error_bag' => $validator->getMessageBag()->toArray(),
                ]
            );

            return null;
        }

        return $validator->validated();
    }

    /**
     * Verfica se o arquivo informado existe e pode ser lido.
     *
     * @param string $file_path full path
     */
    private function isReadable(string $file_path): bool
    {
        $response = is_readable($file_path);

        clearstatcache();

        return $response;
    }

    /**
     * Logs with an arbitrary level.
     *
     * The message MUST be a string or object implementing __toString().
     *
     * The message MAY contain placeholders in the form: {foo} where foo
     * will be replaced by the context data in key "foo".
     *
     * The context array can contain arbitrary data, the only assumption that
     * can be made by implementors is that if an Exception instance is given
     * to produce a stack trace, it MUST be in a key named "exception".
     *
     * @param string                    $level   nível do log
     * @param string|\Stringable        $message sobre o ocorrido
     * @param array<string, mixed>|null $context dados de contexto
     *
     * @see https://www.php-fig.org/psr/psr-3/
     * @see https://www.php.net/manual/en/function.array-merge.php
     */
    private function log(string $level, string|\Stringable $message, ?array $context): void
    {
        Log::log(
            level: $level,
            message: $message,
            context: $context + [
                'file_path' => $this->file_path,
                'node' => $this->node,
                'rules' => $this->rules,
                'max_upsert' => $this->max_upsert,
                'unique' => $this->unique,
                'fields_to_update' => $this->fields_to_update,
            ]
        );
    }
}
