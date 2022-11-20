<?php

declare(strict_types=1);

namespace AeonDigital\Http\Data;

use AeonDigital\Interfaces\Http\Data\iFile as iFile;
use AeonDigital\Interfaces\Http\Data\iFileCollection as iFileCollection;
use AeonDigital\Http\Data\Abstracts\aHttpDataCollection as aHttpDataCollection;





/**
 * Coleção que permite agrupar arquivos enviados via ``Http``.
 *
 * Nesta collection uma mesma chave pode possuir um array de objetos ``File``.
 * Campos enviados vazios serão representados por uma posição com seu respectivo
 * nome e valor ``null``.
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class FileCollection extends aHttpDataCollection implements iFileCollection
{





    /**
     * Inicia um novo objeto ``FileCollection``.
     *
     *
     * @param ?array $initialValues
     * Valores com os quais a instância deve iniciar.
     *
     * @throws \InvalidArgumentException
     * Caso algum dos valores iniciais a serem definidos não
     * seja aceito.
     */
    function __construct(?array $initialValues = [])
    {
        parent::__construct($initialValues);
    }





    /**
     * Libera todos os ``streams`` da coleção para que eles possam ser utilizados por outra
     * tarefa.
     *
     * Após esta ação os métodos das instâncias que dependem diretamente do recurso que foi
     * liberado não irão funcionar.
     *
     * @return void
     */
    public function dropStreams(): void
    {
        $files = $this->toArray();

        foreach ($files as $k => $v) {
            if ($v !== null) {
                if (\is_array($v) === false) {
                    $v->dropStream();
                } else {
                    foreach ($v as $f) {
                        if ($f !== null) {
                            $f->dropStream();
                        }
                    }
                }
            }
        }
    }










    /**
     * Efetua a verificação dos valores que serão adicionados na coleção de headers.
     *
     * Este método **NÃO PODE** lançar exceptions.
     *
     * Apenas retornar ``true`` ou ``false`` mas **PODE/DEVE** alterar o valor da propriedade
     * ``messageInvalidValue`` de forma que a mensagem de erro (caso ocorra) dê informações mais
     * específicas sobre o motivo da falha e aponte o que era esperado de ser recebido.
     *
     *
     * @param mixed $value
     * Valor que será testado.
     *
     * @return bool
     */
    protected function isValidType($value): bool
    {
        if (\is_array($value) === false) {
            $r = ($value === null ||
                (\is_object($value) === true && \in_array(iFile::class, \class_implements($value)) === true)
            );
        } else {
            $c = 0;
            foreach ($value as $v) {
                if (
                    $v === null ||
                    (\is_object($v) === true && \in_array(iFile::class, \class_implements($v)) === true)
                ) {
                    $c++;
                }
            }
            $r = (\count($value) === $c);
        }


        if ($r === false) {
            $this->messageInvalidValue = "Invalid value. Expected instances need to implements interface " . iFile::class . ".";
        }

        return $r;
    }










    /**
     * Utiliza as informações da string indicada para iniciar uma nova coleção de dados.
     *
     * @codeCoverageIgnore
     *
     * @param string $str
     * String que será convertida em uma nova coleção.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso a string passada seja inválida para construção de
     * uma nova coleção.
     */
    public static function fromString(string $str): FileCollection
    {
        throw new \RuntimeException("Not implemented.");
    }
}
