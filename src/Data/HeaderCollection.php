<?php
declare (strict_types = 1);

namespace AeonDigital\Http\Data;

use AeonDigital\Interfaces\Collection\iCaseInsensitiveCollection as iCaseInsensitiveCollection;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Http\Data\Abstracts\aHttpDataCollection as aHttpDataCollection;






/**
 * Coleção que permite agrupar Headers ``Http``.
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class HeaderCollection extends aHttpDataCollection implements iHeaderCollection, iCaseInsensitiveCollection
{





    /**
     * Ajusta o nome das chaves dos headers para o armazenamento padrão.
     * Como esta classe é ``case insensitive`` os valores serão armazenados sempre em
     * ``lowercase`` mas qualquer ``_`` será convertido em ``-`` que é o separador padrão
     * para os headers ``Http``.
     *
     * @param       string $key
     *              Chave que será transformada (se necessário).
     *
     * @param       mixed $value
     *              Valor que está sendo definido no momento.
     *
     * @return      string
     */
    protected function useKey(string $key, $value = null) : string
    {
        $k = (($this->isCaseInsensitive() === false) ? $key : \strtolower($key));
        return \str_replace(["_", " "], "-", $k);
    }





    /**
     * Retorna uma representação dos dados da coleção em formato de string.
     *
     * @param       ?bool $originalKeys
     *              Quando ``true`` irá usar as chaves conforme foram definidas na função ``set``.
     *              Se no armazenamento interno elas sofrerem qualquer alteração e for definido
     *              ``false`` então elas retornarão seu formato alterado.
     *
     * @return      string
     */
    public function toString(?bool $originalKeys = false) : string
    {
        $r = [];
        $coll = $this->toArray($originalKeys);

        foreach ($coll as $k => $v) {
            $r[] = $k . ": " . \implode(", ", $v);
        }

        return \implode("\n", $r);
    }
    /**
     * Retorna toda a coleção atualmente armazenada em um array associativo [ string => mixed ].
     *
     * Em caso de uma coleção vazia será retornado ``[]``.
     *
     * Prioriza o retorno das chaves conforme usadas internamente pois considera que se há uma
     * alteração nelas deve-se a alguma importância relacionado a seu formato de uso.
     *
     * @param       ?bool $originalKeys
     *              Quando ``true`` irá usar as chaves conforme foram definidas na função ``set``.
     *              Se no armazenamento interno elas sofrerem qualquer alteração e for definido
     *              ``false`` então elas retornarão seu formato alterado.
     *
     * @return      array
     */
    public function toArray(?bool $originalKeys = false) : array
    {
        return $this->retrieveCollection($originalKeys, [$this, "prettyHeaderKey"]);
    }
    /**
     * Função responsável por deixar padronizado o formato dos nomes dos headers.
     *
     * @param       string $key
     *              Chave do header que será padrinizada.
     *
     * @return      string
     */
    protected function prettyHeaderKey(string $key) : string
    {
        return \strtr(\ucwords(\strtr(\strtr(\strtolower($key), "_", " "), "-", " ")), " ", "-");
    }










    /**
     * Inicia um novo objeto ``HeaderCollection``.
     * Cada entrada corresponde a um array de valores conforme o modelo:
     *
     * ```
     *  header => string[];
     * ```
     *
     *
     * @param       ?array $initialValues
     *              Valores com os quais a instância deve iniciar.
     *
     *
     * @throws      \InvalidArgumentException
     *              Caso algum dos valores iniciais a serem definidos não seja aceito.
     */
    function __construct(?array $initialValues = [])
    {
        parent::__construct($initialValues);
    }










    /**
     * Se o valor do header a ser adicionado for uma string, desmembra ele em um array de
     * strings. Outros tipos de valores não serão modificados e falharão na etapa de validação
     * de valores.
     *
     * @param       mixed $value
     *              Valor que será verificado ou transformado.
     *
     * @param       mixed $oldValue
     *              Se já há um valor definido para a chave, este deverá ser enviado para
     *              possível uso.
     *
     * @return      mixed
     */
    protected function beforeSet($value, $oldValue = null)
    {
        $useVal = $value;

        if (\is_string($useVal) === true || \is_numeric($useVal) === true) {
            $useVal = \array_map("trim", \explode(",", (string)$useVal));
        }

        if (\is_array($useVal) === true) {
            $useVal = (($oldValue === null) ? $useVal : \array_merge($oldValue, $useVal));
            $useVal = \array_values(\array_unique($useVal, SORT_REGULAR));
        }

        if ($this->isProtected() === true) {
            if (\is_array($useVal) === true) {
                $useVal = \array_merge($useVal, []);
            } elseif (\is_object($useVal) === true) {
                $useVal = clone $useVal;
            }
        }

        return $useVal;
    }





    /**
     * Efetua a verificação dos valores que serão adicionados na coleção de headers.
     *
     * Este método **NÃO PODE** lançar exceptions.
     *
     * Apenas retornar ``true`` ou ``false`` mas **PODE/DEVE** alterar o valor da propriedade
     * ``messageInvalidValue`` de forma que a mensagem de erro (caso ocorra) dê informações
     * mais específicas sobre o motivo da falha e aponte o que era esperado de ser recebido.
     *
     *
     * @param       mixed $value
     *              Valor que será testado.
     *
     * @return      bool
     */
    protected function isValidType($value) : bool
    {
        $r = (\is_string($value) === true || (\is_array($value) === true && \array_is_assoc($value) === false));

        // Se for um array de valores, o array
        // só pode conter strings
        if ($r === true && \is_array($value) === true) {
            foreach ($value as $v) {
                if (\is_string($v) === false && \is_numeric($v) === false) {
                    $r = false;
                    break;
                }
            }
        }


        if ($r === false) {
            $this->messageInvalidValue = "Invalid header value. Only accept string or array[string[]].";
        }

        return $r;
    }










    /**
     * Utiliza as informações da string indicada para iniciar uma nova coleção de dados.
     *
     * @param       string $str
     *              String que será convertida em uma nova coleção.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso a string passada seja inválida para construção de uma nova coleção.
     */
    public static function fromString(string $str) : HeaderCollection
    {
        $h = [];
        $lines = \explode("\n", $str);

        foreach ($lines as $line) {
            $kp = \array_map("trim", \explode(":", $line));
            if (\count($kp) !== 2) {
                throw new \InvalidArgumentException("Invalid given value. Cant convert to headers collection.");
            } else {
                $k = $kp[0];
                $v = \array_map("trim", \explode(",", $kp[1]));
                $h[$k] = $v;
            }
        }

        return new HeaderCollection($h);
    }





    /**
     * Retorna uma string representando toda a coleção de valores determinados para o header
     * de nome indicado. Cada valor é separado por virgula.
     *
     * Uma string vazia será retornada caso o header não exista.
     *
     * @param       string $key
     *              Nome do header alvo.
     *
     * @return      string
     */
    public function getHeaderLine(string $key) : string
    {
        $str = "";

        if ($this->has($key) === true) {
            $str = \implode(", ", $this->get($key));
        }

        return $str;
    }

}
