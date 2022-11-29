<?php

declare(strict_types=1);

namespace AeonDigital\Http\Message;

use Psr\Http\Message\ServerRequestInterface as ServerRequestInterface;
use Psr\Http\Message\UriInterface as UriInterface;
use Psr\Http\Message\StreamInterface as StreamInterface;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Interfaces\Http\Data\iUploadedFileCollection as iUploadedFileCollection;
use AeonDigital\Interfaces\Http\Data\iCookieCollection as iCookieCollection;
use AeonDigital\Interfaces\Http\Data\iQueryStringCollection as iQueryStringCollection;
use AeonDigital\Interfaces\Collection\iCollection as iCollection;
use AeonDigital\Http\Message\PSRRequest as PSRRequest;




/**
 * Encapsula todos os objetos que representam na totalidade uma requisição recebida pelo servidor.
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * @see         http://www.php-fig.org/psr/
 *
 * @package     AeonDigital\Http\Message
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class PSRServerRequest extends PSRRequest implements ServerRequestInterface
{





    /**
     * Objeto principal.
     *
     * @var AeonDigital\Http\Message\ServerRequest
     */
    private \AeonDigital\Http\Message\ServerRequest $mainObj;



    /**
     * Inicia um novo objeto ``ServerRequest``.
     *
     * @param string $httpMethod
     * Método ``Http`` que está sendo usado para a requisição.
     * Este valor será substituido caso um parametro ``_method`` seja enviado em
     * algum parametro da requisição (seja via GET, POST ou outra forma).
     *
     * @param UriInterface $uri
     * Objeto que implementa a interface ``iUri`` configurado com a ``URI`` que está
     * sendo requisitada pelo ``UA``.
     *
     * @param string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection``
     * cotendo os cabeçalhos da requisição.
     *
     * @param StreamInterface $body
     * Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param iCookieCollection $cookies
     * Objeto que implementa ``iCookieCollection`` cotendo os cookies da requisição.
     *
     * @param iQueryStringCollection $queryStrings
     * Objeto que implementa ``iQueryStringCollection`` cotendo os queryStrings.
     *
     * @param iUploadedFileCollection $files
     * Objeto que implementa ``iUploadedFileCollection`` cotendo os arquivos enviados nesta
     * requisição.
     *
     * @param array $serverParans
     * Coleção de parametros definidos pelo servidor sobre o ambiente e requisição
     * atual.
     *
     * @param iCollection $attributes
     * Objeto que implementa ``iCollection`` contendo atributos personalizados para
     * esta requisição.
     *
     * @param ?iCollection $bodyParsers
     * Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar
     * o processamento do body da requisição.
     *
     * @throws \InvalidArgumentException
     *
     * @throws \RuntimeException
     */
    function __construct(
        string $httpMethod,
        UriInterface $uri,
        string $httpVersion,
        iHeaderCollection $headers,
        StreamInterface $body,
        iCookieCollection $cookies,
        iQueryStringCollection $queryStrings,
        iUploadedFileCollection $files,
        array $serverParans,
        iCollection $attributes,
        ?iCollection $bodyParsers = null
    ) {
        $this->mainObj = new \AeonDigital\Http\Message\ServerRequest(
            $httpMethod,
            \AeonDigital\Http\Uri\Uri::fromPSR($uri),
            $httpVersion,
            $headers,
            \AeonDigital\Http\Stream\Stream::fromPSR($body),
            $cookies,
            $queryStrings,
            $files,
            $serverParans,
            $attributes,
            $bodyParsers
        );
    }





    /**
     * Retrieve server parameters.
     *
     * Retrieves data related to the incoming request environment,
     * typically derived from PHP's $_SERVER superglobal. The data IS NOT
     * REQUIRED to originate from $_SERVER.
     *
     * @return array
     */
    public function getServerParams()
    {
        return $this->mainObj->getServerParams();
    }

    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The data MUST be compatible with the structure of the $_COOKIE
     * superglobal.
     *
     * @return array
     */
    public function getCookieParams()
    {
        return $this->mainObj->getCookieParams();
    }

    /**
     * Return an instance with the specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated cookie values.
     *
     * @param array $cookies Array of key/value pairs representing cookies.
     * @return static
     */
    public function withCookieParams(array $cookies)
    {
        return $this->mainObj->withCookieParams($cookies)->toPSR();
    }

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * Note: the query params might not be in sync with the URI or server
     * params. If you need to ensure you are only getting the original
     * values, you may need to parse the query string from `getUri()->getQuery()`
     * or from the `QUERY_STRING` server param.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->mainObj->getQueryParams();
    }

    /**
     * Return an instance with the specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated query string arguments.
     *
     * @param array $query Array of query string arguments, typically from
     *     $_GET.
     * @return static
     */
    public function withQueryParams(array $query)
    {
        return $this->mainObj->withQueryParams($query)->toPSR();
    }

    /**
     * Retrieve normalized file upload data.
     *
     * This method returns upload metadata in a normalized tree, with each leaf
     * an instance of Psr\Http\Message\UploadedFileInterface.
     *
     * These values MAY be prepared from $_FILES or the message body during
     * instantiation, or MAY be injected via withUploadedFiles().
     *
     * @return array An array tree of UploadedFileInterface instances; an empty
     *     array MUST be returned if no data is present.
     */
    public function getUploadedFiles()
    {
        return $this->mainObj->getUploadedFiles();
    }

    /**
     * Create a new instance with the specified uploaded files.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
     * @return static
     * @throws \InvalidArgumentException if an invalid structure is provided.
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        return $this->mainObj->withUploadedFiles($uploadedFiles)->toPSR();
    }

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, this method MUST
     * return the contents of $_POST.
     *
     * Otherwise, this method may return any results of deserializing
     * the request body content; as parsing returns structured content, the
     * potential types MUST be arrays or objects only. A null value indicates
     * the absence of body content.
     *
     * @return null|array|object The deserialized body parameters, if any.
     *     These will typically be an array or object.
     */
    public function getParsedBody()
    {
        return $this->mainObj->getParsedBody();
    }

    /**
     * Return an instance with the specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or objects,
     * or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated body parameters.
     *
     * @param null|array|object $data The deserialized body data. This will
     *     typically be in an array or object.
     * @return static
     * @throws \InvalidArgumentException if an unsupported argument type is
     *     provided.
     */
    public function withParsedBody($data)
    {
        return $this->mainObj->withParsedBody($data)->toPSR();
    }

    /**
     * Retrieve attributes derived from the request.
     *
     * The request "attributes" may be used to allow injection of any
     * parameters derived from the request: e.g., the results of path
     * match operations; the results of decrypting cookies; the results of
     * deserializing non-form-encoded message bodies; etc. Attributes
     * will be application and request specific, and CAN be mutable.
     *
     * @return array Attributes derived from the request.
     */
    public function getAttributes()
    {
        return $this->mainObj->getAttributes();
    }

    /**
     * Retrieve a single derived request attribute.
     *
     * Retrieves a single derived request attribute as described in
     * getAttributes(). If the attribute has not been previously set, returns
     * the default value as provided.
     *
     * This method obviates the need for a hasAttribute() method, as it allows
     * specifying a default value to return if the attribute is not found.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @param mixed $default Default value to return if the attribute does not exist.
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return $this->mainObj->getAttribute($name, $default);
    }

    /**
     * Return an instance with the specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * updated attribute.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @param mixed $value The value of the attribute.
     * @return static
     */
    public function withAttribute($name, $value)
    {
        return $this->mainObj->withAttribute($name, $value)->toPSR();
    }

    /**
     * Return an instance that removes the specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the attribute.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @return static
     */
    public function withoutAttribute($name)
    {
        return $this->mainObj->withoutAttribute($name)->toPSR();
    }
}
