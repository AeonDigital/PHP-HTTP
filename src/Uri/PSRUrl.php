<?php

declare(strict_types=1);

namespace AeonDigital\Http\Uri;

use Psr\Http\Message\UriInterface as UriInterface;
use AeonDigital\BObject as BObject;






/**
 * Classe concreta de uma Url.
 *
 * Esta classe implementa a interface ``Psr\Http\Message\UriInterface``.
 *
 * @package     AeonDigital\Http\Uri
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 *
 * @codeCoverageIgnore
 */
class PSRUrl extends BObject implements UriInterface
{





    /**
     * Objeto principal.
     *
     * @var AeonDigital\Http\Uri\Url
     */
    private \AeonDigital\Http\Uri\Url $url;



    /**
     * Inicia uma instância ``Url``.
     *
     * @param string $scheme
     * Define o ``scheme`` usado pelo ``URI``.
     *
     * @param string $user
     * Define o ``user`` usado pelo ``URI``.
     *
     * @param ?string $password
     * Define o ``password`` usado pelo ``URI``.
     * Se ``null`` for passado, o valor da ``password`` não será removido.
     *
     * @param string $host
     * Define o ``host`` usado pelo ``URI``.
     *
     * @param ?int $port
     * Define a ``port`` usado pelo ``URI``.
     * Use ``null`` para usar o valor padrão para do ``scheme``.
     *
     * @param string $path
     * Define o ``path`` usado pelo ``URI``.
     *
     * @param string $query
     * Define o ``query`` usado pelo ``URI``.
     *
     * @param string $fragment
     * Define o ``fragment`` usado pelo ``URI``.
     *
     * @throws \InvalidArgumentException
     * Caso algum dos parametros passados seja inválido.
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
        $this->stream = new \AeonDigital\Http\Uri\Url(
            $scheme,
            $user,
            $password,
            $host,
            $port,
            $path,
            $query,
            $fragment
        );
    }





    /**
     * Retorna o nome do ``scheme`` que o ``URI`` da classe está usando.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->url->getScheme();
    }

    /**
     * Componente ``authority`` da ``URI``.
     * Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
     * este formato.
     *
     * A sintaxe padrão deste componente é:
     *
     * ```txt
     *  [[user-info@]host[:port]]
     * ```
     *
     * O componente ``port`` deve ser omitido quando esta não estiver definida, ou, se for uma
     * das portas padrão para o ``scheme`` atualmente em uso.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.2
     *
     * @return string
     */
    public function getAuthority()
    {
        return $this->url->getAuthority();
    }

    /**
     * Componente ``user information`` da ``URI``.
     * Se este componente não estiver presente na ``URI`` será retornado ``''``.
     * Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
     * este formato.
     *
     * A sintaxe padrão deste componente é:
     *
     * ```txt
     *  [username[:password]]
     * ```
     *
     * @return string
     */
    public function getUserInfo()
    {
        return $this->url->getUserInfo();
    }

    /**
     * Retorna o componente ``host`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->url->getHost();
    }

    /**
     * Retorna o componente ``port`` da ``URI`` ou ``null`` caso a porta definida seja a padrão
     * para o ``scheme`` que está sendo usado.
     *
     * @return ?int
     */
    public function getPort()
    {
        return $this->url->getPort();
    }

    /**
     * Retorna o componente ``path`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O valor será retornado usando ``percent-encoding``.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->url->getPath();
    }

    /**
     * Retorna o componente ``query`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O caracter ``?`` não faz parte do componente ``query``.
     *
     * Os valores definidos serão retornados usando ``percent-encoding``.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->url->getQuery();
    }

    /**
     * Retorna o componente ``fragment`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O caracter ``#`` não faz parte do componente ``fragment``.
     *
     * Os valores definidos serão retornados usando ``percent-encoding``.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-3.4
     *
     * @return string
     */
    public function getFragment()
    {
        return $this->url->getFragment();
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``scheme`` especificado.
     *
     * @param string $scheme
     * O novo valor para ``scheme`` para a nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``scheme``.
     */
    public function withScheme($scheme)
    {
        return $this->url->withScheme();
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``user information`` especificado.
     *
     * @param string $user
     * O novo valor para ``user`` na nova instância.
     *
     * @param string $password
     * O novo valor para ``password`` na nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para algum argumento.
     */
    public function withUserInfo($user, $password = null)
    {
        return $this->url->withUserInfo($user, $password);
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``host`` especificado.
     *
     * @param string $host
     * O novo valor para ``host`` para a nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``host``.
     */
    public function withHost($host)
    {
        return $this->url->withHost($host);
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``port`` especificado.
     *
     * @param ?int $port
     * O novo valor para ``port`` para a nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``port``.
     */
    public function withPort($port)
    {
        return $this->url->withPort($port);
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``path`` especificado.
     *
     * @param string $path
     * O novo valor para ``path`` para a nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``path``.
     */
    public function withPath($path)
    {
        return $this->url->withPath($path);
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``query`` especificado.
     *
     * @param string $query
     * O novo valor para ``query`` na nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``query``.
     */
    public function withQuery($query)
    {
        return $this->url->withQuery($query);
    }

    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``fragment`` especificado.
     *
     * @param string $fragment
     * O novo valor para ``fragment`` na nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``fragment``.
     */
    public function withFragment($fragment)
    {
        return $this->url->withFragment($fragment);
    }

    /**
     * Converte os atributos que formam a ``URI`` em uma string válida para seu respectivo ``scheme``.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->url;
    }
}
