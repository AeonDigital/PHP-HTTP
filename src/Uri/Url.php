<?php

declare(strict_types=1);

namespace AeonDigital\Http\Uri;

use Psr\Http\Message\UriInterface as UriInterface;
use AeonDigital\Interfaces\Http\Uri\iUrl as iUrl;
use AeonDigital\Http\Uri\Abstracts\aAbsoluteUri as aAbsoluteUri;





/**
 * Classe concreta de uma Url.
 *
 * Esta classe é compatível com a PSR ``Psr\Http\Message\UriInterface`` mas não a implementa
 * de forma direta. Use a classe ``PSRUrl`` ou o método ``toPSR`` para obter uma instância
 * que implemente tal interface.
 *
 * @package     AeonDigital\Http\Uri
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Url extends aAbsoluteUri implements iUrl
{



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
        parent::__construct($scheme, $user, $password, $host, $port, $path, $query, $fragment);
    }





    /**
     * Retorna uma instância deste mesmo objeto, porém, compatível com a interface
     * original ``Psr\Http\Message\UriInterface``.
     */
    public function toPSR(): UriInterface
    {
        return new \AeonDigital\Http\Uri\PSRUrl(
            $this->scheme,
            $this->user,
            $this->password,
            $this->host,
            $this->port,
            $this->path,
            $this->query,
            $this->fragment
        );
    }
}
