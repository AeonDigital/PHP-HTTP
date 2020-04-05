<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Abstracts;

use AeonDigital\Interfaces\Http\Uri\iAbsoluteUri as iAbsoluteUri;
use AeonDigital\Http\Uri\Abstracts\aHierPartUri as aHierPartUri;







/**
 * Implementa a interface ``iAbsoluteUri``.
 *
 * @package     AeonDigital\Http\Uri
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
abstract class aAbsoluteUri extends aHierPartUri implements iAbsoluteUri
{





    /**
     * Componente ``query`` da URI.
     *
     * @var         string
     */
    protected $query = "";
    /**
     * Retorna o componente ``query`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O caracter ``?`` não faz parte do componente ``query``.
     *
     * Os valores definidos serão retornados usando ``percent-encoding``.
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @return      string
     */
    public function getQuery() : string
    {
        return $this->query;
    }





    /**
     * Verifica se o ``query`` indicado é válido.
     *
     * @param       string $query
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma exception em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``query`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateQuery($query, bool $throw = false) : bool
    {
        $r = (is_string($query) === true);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"query\" value. Must be an string.");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``query`` indicado.
     * Este método aplica ``percent-encode`` nos valores de cada parametro de uma querystring.
     *
     * Os valores usados devem estar separados pelo caracter ``&``. Se o caracter ``&`` faz
     * parte do valor de algum dos parametros, ele deve estar convertido em seu formato
     * ``percent-encode`` (%26amp%3B).
     *
     * @param       string $query
     *              Valor de ``query``.
     *
     * @return      string
     */
    protected function normalizeQuery(string $query) : string
    {
        $nQuery = [];

        // Divide a query em cada um de seus componentes chave=valor
        $queryParts = explode("&", $query);

        foreach ($queryParts as $q) {
            $keyVal = explode("=", $q);

            if ($keyVal[0] !== "") {
                $nQuery[] = $keyVal[0] . "=" . ((count($keyVal) === 2) ? $this->percentEncode($keyVal[1]) : "");
            }
        }

        return implode("&", $nQuery);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``query`` especificado.
     *
     * @param       string $query
     *              O novo valor para ``query`` na nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``query``.
     */
    public function withQuery($query)
    {
        $this->validateQuery($query, true);

        $clone = clone $this;
        $clone->query = $this->normalizeQuery($query);
        return $clone;
    }










    /**
     * Componente ``fragment`` da ``URI``.
     *
     * @var         string
     */
    protected $fragment = "";
    /**
     * Retorna o componente ``fragment`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O caracter ``#`` não faz parte do componente ``fragment``.
     *
     * Os valores definidos serão retornados usando ``percent-encoding``.
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @return      string
     */
    public function getFragment() : string
    {
        return $this->fragment;
    }





    /**
     * Verifica se o ``fragment`` indicado é válido.
     *
     * @param       string $fragment
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``fragment`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateFragment($fragment, bool $throw = false) : bool
    {
        $r = (is_string($fragment) === true);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"fragment\" value. Must be an string.");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``fragment`` indicado.
     *
     * Se o caracter ``&``  faz parte do valor de algum dos parametros, ele deve estar
     * convertido em seu formato ``percent-encode`` (%26amp%3B).
     *
     * @param       string $query
     *              Valor de ``fragment``.
     *
     * @return      string
     */
    protected function normalizeFragment(string $fragment) : string
    {
        return $this->percentEncode($fragment);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``fragment`` especificado.
     *
     * @param       string $fragment
     *              O novo valor para ``fragment`` na nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``fragment``.
     */
    public function withFragment($fragment)
    {
        $this->validateFragment($fragment, true);

        $clone = clone $this;
        $clone->fragment = $this->normalizeFragment($fragment);
        return $clone;
    }










    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo a parte ``relative-uri`` especificado.
     *
     * @param       string $path
     *              O novo valor para ``path`` na nova instância.
     *
     * @param       string $query
     *              O novo valor para ``query`` na nova instância.
     *
     * @param       string $fragment
     *              O novo valor para ``fragment`` na nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para algum argumento.
     */
    public function withRelativeUri($path = "", $query = "", $fragment = "")
    {
        $this->validatePath($path, true);
        $this->validateQuery($query, true);
        $this->validateFragment($fragment, true);

        $clone = clone $this;
        $clone->path = $this->normalizePath($path);
        $clone->query = $this->normalizeQuery($query);
        $clone->fragment = $this->normalizeFragment($fragment);
        return $clone;
    }










    /**
     * Inicia uma instância ``absoluteUri`` de uma ``URI``.
     *
     * @param       string $scheme
     *              Define o ``scheme`` usado pelo ``URI``.
     *
     * @param       string $user
     *              Define o ``user`` usado pelo ``URI``.
     *
     * @param       ?string $password
     *              Define o ``password`` usado pelo ``URI``.
     *              Se ``null`` for passado, o valor da ``password`` não será removido.
     *
     * @param       string $host
     *              Define o ``host`` usado pelo ``URI``.
     *
     * @param       ?int $port
     *              Define a ``port`` usado pelo ``URI``.
     *              Use ``null`` para usar o valor padrão para do ``scheme``.
     *
     * @param       string $path
     *              Define o ``path`` usado pelo ``URI``.
     *
     * @param       string $query
     *              Define o ``query`` usado pelo ``URI``.
     *
     * @param       string $fragment
     *              Define o ``fragment`` usado pelo ``URI``.
     *
     * @throws      \InvalidArgumentException
     *              Caso algum dos parametros passados seja inválido.
     */
    function __construct(
        string $scheme = "",
        string $user = "",
        ?string $password = null,
        string $host = "",
        ?int $port = null,
        string $path = "",
        string $query = "",
        string $fragment = ""
    ) {
        parent::__construct($scheme, $user, $password, $host, $port, $path);

        $this->validateQuery($query, true);
        $this->validateFragment($fragment, true);

        $this->query = $this->normalizeQuery($query);
        $this->fragment = $this->normalizeFragment($fragment);
    }










    /**
     * Retorna uma string que representa toda a uri representada pela atual instância.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ][ "/" path ][ "?" query ][ "#" fragment ]
     * ```
     *
     * @param       bool $withFragment
     *              Quando ``true`` irá adicionar o componente ``fragment``.
     *              Se ``false`` irá omitir totalmente este componente.
     *
     * @return      string
     */
    public function getAbsoluteUri(bool $withFragment = false) : string
    {
        $basePath = $this->getBasePath();
        $query = $this->getQuery();
        $fragment = (($withFragment === true) ? $this->getFragment() : "");

        $absoluteUri = $basePath . (($query === "") ? "" : "?" . $query) . (($fragment === "") ? "" : "#" . $fragment);

        return $absoluteUri;
    }



    /**
     * Retorna uma string que representa toda a parte relativa da ``URI`` atualmente representada
     * pela instância.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ "/" path ][ "?" query ][ "#" fragment ]
     * ```
     *
     * @param       bool $withFragment
     *              Quando ``true`` irá adicionar o componente ``fragment``.
     *              Se ``false`` irá omitir totalmente este componente.
     *
     * @return      string
     */
    public function getRelativeUri(bool $withFragment = false) : string
    {
        $path = $this->getPath();
        $query = $this->getQuery();
        $fragment = (($withFragment === true) ? $this->getFragment() : "");

        $relativePart = $path . (($query === "") ? "" : "?" . $query) . (($fragment === "") ? "" : "#" . $fragment);

        return $relativePart;
    }










    /**
     * Retorna uma nova instância definida a partir do valor indicado na string ``$uri``.
     *
     * @param       string $uri
     *              ``URI`` que será usada de base para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Exception lançada caso a ``URI`` indicada seja inválida.
     */
    public static function fromString(string $uri)
    {
        $components = parse_url($uri);

        $scheme = ($components["scheme"] ?? "");
        $host = ($components["host"] ?? "");
        $port = ($components["port"] ?? null);
        $path = ($components["path"] ?? "");
        $query = ($components["query"] ?? "");
        $fragment = ($components["fragment"] ?? "");

        $user = ($components["user"] ?? "");
        $password = ($components["pass"] ?? null);

        if ($port !== null) {
            $port = (int)$port;
        }

        return new static($scheme, $user, $password, $host, $port, $path, $query, $fragment);
    }



    /**
     * Converte os atributos que formam a ``URI`` em uma string válida para seu respectivo ``scheme``.
     *
     * @return      string
     */
    public function __toString()
    {
        return $this->getAbsoluteUri(true);
    }
}
