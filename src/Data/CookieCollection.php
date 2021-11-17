<?php
declare (strict_types = 1);

namespace AeonDigital\Http\Data;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\Interfaces\Http\Data\iCookieCollection as iCookieCollection;
use AeonDigital\Http\Data\Abstracts\aHttpDataCollection as aHttpDataCollection;






/**
 * Coleção que permite agrupar Cookies.
 *
 * @see         http://www.ietf.org/rfc/rfc6265.txt
 * @see         https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class CookieCollection extends aHttpDataCollection implements iCookieCollection
{




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
        $ckie = $this->toArray($originalKeys);

        foreach ($ckie as $k => $v) {
            $r[] = $v->toString();
        }

        return \implode(" ", $r);
    }
    /**
     * Retorna toda a coleção atualmente armazenada em um array associativo [ string => mixed ].
     *
     * Em caso de uma coleção vazia será retornado ``[]``.
     *
     * O nome das chaves será sempre o próprio nome do cookie portanto o parametro
     * ``$originalKeys`` não funcionará para esta collection.
     *
     * @param       ?bool $originalKeys
     *
     * @return      array
     */
    public function toArray(?bool $originalKeys = false) : array
    {
        return $this->retrieveCollection();
    }










    /**
     * Ajusta o nome das chaves dos cookies para que seja sempre o mesmo nome definido para o
     * cookie passado.
     *
     * @param       string $key
     *              Chave que será transformada (se necessário).
     *
     * @param       mixed $value
     *              Objeto cookie.
     *
     * @return      string
     */
    protected function useKey(string $key, $value = null) : string
    {
        if ($value !== null && $this->isValidType($value) === false) {
            throw new \InvalidArgumentException($this->messageInvalidValue);
        }

        return (($value === null) ? $key : $value->getName());
    }










    /**
     * Inicia um novo objeto ``CookieCollection``.
     *
     * Nesta coleção a chave identificadora dos itens da coleção será sempre o mesmo nome de
     * cada cookie indicado.
     *
     *
     * @param       ?array $initialValues
     *              Valores com os quais a instância deve iniciar.
     *
     * @throws      \InvalidArgumentException
     *              Caso algum dos valores iniciais a serem definidos não seja aceito.
     */
    function __construct(?array $initialValues = [])
    {
        parent::__construct($initialValues);
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
        $r = (\is_object($value) === true && \in_array(iCookie::class, \class_implements($value)) === true);

        if ($r === false) {
            $this->messageInvalidValue = "Invalid value. Expected instance to implement interface " . iCookie::class . ".";
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
    public static function fromString(string $str) : CookieCollection
    {
        $cookies = \AeonDigital\Http\Data\Cookie::fromRawCookieHeader($str);
        return new CookieCollection($cookies);
    }
}
