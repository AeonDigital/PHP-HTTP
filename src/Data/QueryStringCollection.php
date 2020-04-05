<?php
declare (strict_types = 1);

namespace AeonDigital\Http\Data;

use AeonDigital\Interfaces\Http\Data\iQueryStringCollection as iQueryStringCollection;
use AeonDigital\Http\Data\Abstracts\aHttpDataCollection as aHttpDataCollection;






/**
 * Coleção que permite agrupar QueryStrings.
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class QueryStringCollection extends aHttpDataCollection implements iQueryStringCollection
{




    /**
     * Indica quando é ou não para retornar os valores da instância usando ``percent-encode``.
     * Mesmo que seja ``false``, internamente os valores serão sempre armazenados utilizando-se
     * desta conversão.
     *
     *
     * @var         bool
     */
    protected $isUsePercentEncode = true;



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
            $r[] = $k . "=" . $v;
        }

        return \implode("&", $r);
    }










    /**
     * Inicia um novo objeto ``QueryStringCollection``.
     * Cada entrada corresponde a um array de valores conforme o modelo:
     *
     * ```
     *  querystring => string
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
     * Permite determinar quando os valores retornados pela coleção devem ou não estar usando
     * ``percent-encode``.
     *
     * Internamente os valores devem **SEMPRE** serem armazenados utilizando tal encode, mas ao
     * retornar os dados eles devem ser alterados caso seja definido ``false``.
     *
     * @param       bool $use
     *              Indica se a coleção deve retornar os valores utilizando ``percent-encode`` ou não.
     *
     * @return      void
     */
    public function usePercentEncode(bool $use) : void
    {
        $this->isUsePercentEncode = $use;
    }










    /**
     * Aplica ``percent-encoding`` aos caracteres ``unsafe``.
     *
     * @param       string $value
     *              Valor que será encodado.
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-2.1
     * @see         http://www.faqs.org/rfcs/rfc3986.html
     *
     * @return      string
     */
    protected function percentEncode(string $value) : string
    {
        // Se o valor já está encodado... remove encoding
        $value = \str_replace("+", "%20", $value);
        while ((\strpos($value, "%") !== false && \rawurlencode(\rawurldecode($value)) === $value)) {
            $value = \rawurldecode($value);
        }

        return \rawurlencode($value);
    }
    /**
     * Antes de inserir o valor da ``querystring`` na coleção efetua a conversão de seus
     * caracteres ``unsafe`` para ``percent-encode``.
     *
     * @param       mixed $value
     *              Valor que será verificado ou transformado.
     *
     * @param       mixed $oldValue
     *              Se já há um valor definido para a chave, este deverá ser enviado para possível
     *              uso.
     *
     * @return      mixed
     */
    protected function beforeSet($value, $oldValue = null)
    {
        $useVal = $value;

        if (\is_string($value) === true) {
            $useVal = $this->percentEncode($value);
        }

        return $useVal;
    }
    /**
     * Resgata um valor da coleção a partir do nome da chave indicada.
     *
     * @param       string $key
     *              Nome da chave cujo valor deve ser retornado.
     *
     * @return      mixed|null
     *
     *
     * @throws      \InvalidArgumentException
     *              Caso a regra da classe concreta defina que em caso de ser passado uma chave
     *              inexistente seja lançada uma exception.
     */
    public function get(string $key)
    {
        $v = $this->beforeGet($key);
        return (($this->isUsePercentEncode === true || $v === null) ? $v : \rawurldecode($v));
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
     * @param       mixed $value
     *              Valor que será testado.
     *
     * @return      bool
     */
    protected function isValidType($value) : bool
    {
        $r = (\is_string($value) === true);

        if ($r === false) {
            $this->messageInvalidValue = "Invalid querystring value. Only accept string.";
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
    public static function fromString(string $str) : QueryStringCollection
    {
        \parse_str($str, $initialValues);
        return new QueryStringCollection($initialValues);
    }
}
