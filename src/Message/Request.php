<?php

declare(strict_types=1);

namespace AeonDigital\Http\Message;

use Psr\Http\Message\RequestInterface as RequestInterface;
use Psr\Http\Message\ServerRequestInterface as ServerRequestInterface;
use AeonDigital\Interfaces\Http\Message\iRequest as iRequest;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Http\Uri\iUri as iUri;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Http\Message\Abstracts\aMessage as aMessage;


/**
 * Representa uma requisição ``Http`` feita por um ``UA``.
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * Esta classe é compatível com a PSR ``Psr\Http\Message\RequestInterface`` mas não a implementa
 * de forma direta. Use a classe ``PSRRequest`` ou o método ``toPSR`` para obter uma instância
 * que implemente tal interface.
 *
 *
 * @see         http://www.php-fig.org/psr/
 *
 * @package     AeonDigital\Http\Message
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Request extends aMessage implements iRequest
{





    /**
     * Retorna um clone da instância atual e toma cuidado para clonar também qualquer objeto
     * interno que ela possua.
     *
     * @param ?iUri $useUri
     * Objeto ``iUri`` para o clone.
     *
     * @param ?iHeaderCollection $useHeaders
     * Objeto ``header`` para o clone.
     *
     * @param ?iStream $useBody
     * Objeto ``body`` para o clone.
     *
     * @return static
     */
    private function cloneThisInstance(
        ?iUri $useUri = null,
        ?iHeaderCollection $useHeaders = null,
        ?iStream $useBody = null
    ) {
        $clone = clone $this;

        $clone->uri = (($useUri === null) ? clone $this->uri : $useUri);
        $clone->headers = (($useHeaders === null) ? clone $this->headers : $useHeaders);
        $clone->body = (($useBody === null) ? clone $this->body : $useBody);

        return $clone;
    }









    /**
     * Método ``Http`` que está sendo usado na requisição.
     *
     * @var string
     */
    protected string $method = "";
    /**
     * Retorna o método ``Http`` que está sendo usado na requisição.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }





    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``method`` especificado.
     *
     * @param string $method
     * O ``method`` que será usado na nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``method``.
     */
    public function withMethod(string $method): static
    {
        $clone = $this->cloneThisInstance();
        $clone->method = $this->checkMethod($method);

        return $clone;
    }










    /**
     * Instância que implementa a interface ``iUri``.
     *
     * @var iUri
     */
    protected iUri $uri;
    /**
     * Retorna a instância ``iUri`` que está sendo executada.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     *
     * @return iUri
     */
    public function getUri(): iUri
    {
        return $this->uri;
    }





    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o objeto ``iUri`` especificado.
     *
     * @param iUri $uri
     * O objeto ``uri`` que será usado na nova instância.
     *
     * @param bool $preserveHost
     * Preserva o estado original do Header ``Host``.
     *
     * @return static
     */
    public function withUri(iUri $uri, bool $preserveHost = false): static
    {
        $clone = $this->cloneThisInstance($uri);
        $updateHostHeader = (
            ($preserveHost === false && $uri->getHost() !== "") ||
            ($preserveHost === true &&
                (($this->hasHeader("Host") === false || $this->getHeaderLine("Host") === "") && $uri->getHost() !== "")
            )
        );

        if ($updateHostHeader === true) {
            $clone->headers->remove("Host");
            $clone->headers->set("Host", $uri->getHost());
        }

        return $clone;
    }





    /**
     * Retorna uma string que representa a requisição que está sendo executada para o domínio
     * atual.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ "/" path ][ "?" query ][ "#" fragment ]
     * ```
     *
     * @return string
     */
    public function getRequestTarget(): string
    {
        return $this->uri->getRelativeUri(false);
    }





    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``requestTarget`` especificado.
     *
     * @param string $requestTarget
     * Valor de ``requestTarget`` que será usado na nova instância.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``requestTarget``.
     */
    public function withRequestTarget(string $requestTarget): static
    {
        $split = \explode("?", $requestTarget);
        if (\count($split) === 1) {
            $split[] = "";
        }

        $uri = $this->uri->withRelativeUri($split[0], $split[1]);
        $clone = $this->cloneThisInstance($uri);

        return $clone;
    }










    /**
     * Inicia um novo objeto Request.
     *
     * @param string $httpMethod
     * Método ``Http`` que está sendo usado para a requisição.
     *
     * @param iUri $uri
     * Objeto que implementa a interface ``iUri`` configurado com a ``URI`` que
     * está sendo requisitada pelo UA.
     *
     * @param string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da
     * requisição.
     *
     * @param iStream $body
     * Objeto stream que faz parte do corpo da mensagem.
     *
     * @throws \InvalidArgumentException
     */
    function __construct(
        string $httpMethod,
        iUri $uri,
        string $httpVersion,
        iHeaderCollection $headers,
        iStream $body
    ) {
        parent::__construct($httpVersion, $headers, $body);

        $this->headers->remove("Host");
        $this->headers->set("Host", $uri->getHost());

        $this->method = $this->checkMethod($httpMethod);
        $this->uri = $uri;
    }





    /**
     * Verifica se o ``method`` indicado é válido.
     * Retornará o valor do ``method`` normalizado para uso ou irá jogar uma exception caso falhe.
     *
     * @param string $method
     * Valor que será verificado.
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function checkMethod(string $method): string
    {
        return $this->mainCheckForInvalidArgumentException(
            "method",
            $method,
            [
                [
                    "validate" => "is allowed value",
                    "allowedValues" => \array_keys(\AeonDigital\Http\Const\HTTPMethod),
                    "caseInsensitive" => true,
                    "executeBeforeReturn" => function ($args) {
                        return \mb_strtoupper($args["argValue"]);
                    }
                ],
            ]
        );
    }





    /**
     * Retorna uma instância deste mesmo objeto, porém, compatível com a interface
     * em que foi baseada ``Psr\Http\Message\RequestInterface``.
     */
    public function toPSR(): RequestInterface|ServerRequestInterface
    {
        return new \AeonDigital\Http\Message\PSRRequest(
            $this->method,
            $this->uri->toPSR(),
            $this->protocolVersion,
            $this->headers,
            $this->body->toPSR()
        );
    }
    /**
     * A partir de um objeto ``Psr\Http\Message\RequestInterface``, retorna um novo que implementa
     * a interface ``AeonDigital\Interfaces\Http\Message\iRequest``.
     *
     * @param RequestInterface|ServerRequestInterface $obj
     * Instância original.
     *
     * @return static
     * Nova instância, sob nova interface.
     *
     * @throws \InvalidArgumentException
     * Se por qualquer motivo não for possível retornar uma nova instância a partir da
     * que foi passada
     */
    public static function fromPSR(RequestInterface|ServerRequestInterface $obj): static
    {
        $lineHeaders = [];
        foreach ($obj->getHeaders() as $name => $values) {
            $lineHeaders[] = $name . ": " . implode(", ", $values);
        }

        return new \AeonDigital\Http\Message\Request(
            $obj->getMethod(),
            \AeonDigital\Http\Uri\Uri::fromString((string)$obj->getUri()),
            $obj->getProtocolVersion(),
            \AeonDigital\Http\Data\HeaderCollection::fromString(\implode("\n", $lineHeaders)),
            \AeonDigital\Http\Stream\Stream::fromPSR($obj->getBody())
        );
    }
}
