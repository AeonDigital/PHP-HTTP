<?php

declare(strict_types=1);

namespace AeonDigital\Http;

use AeonDigital\Interfaces\Http\iFactory as iFactory;
use AeonDigital\Interfaces\Http\Uri\iUrl as iUrl;
use AeonDigital\Interfaces\Http\Message\iRequest as iRequest;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Interfaces\Http\Data\iCookieCollection as iCookieCollection;
use AeonDigital\Interfaces\Http\Data\iQueryStringCollection as iQueryStringCollection;
use AeonDigital\Interfaces\Http\Data\iFileCollection as iFileCollection;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Stream\iFileStream as iFileStream;
use AeonDigital\Interfaces\Collection\iCollection as iCollection;
use AeonDigital\BObject as BObject;





/**
 * Implementação de ``iFactory``.
 *
 * @package     AeonDigital\Http
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Factory extends BObject implements iFactory
{





    /**
     * Retorna uma coleção de headers baseado nos valores passados.
     *
     * O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iHeaderCollection``.
     *
     * @param ?array $initialValues
     * Valores iniciais dos headers.
     *
     * @return iHeaderCollection
     */
    public function createHeaderCollection(?array $initialValues = null): iHeaderCollection
    {
        return new \AeonDigital\Http\Data\HeaderCollection($initialValues);
    }
    /**
     * Retorna uma coleção de headers baseado nos valores passados.
     *
     * O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iCookieCollection``.
     *
     * @param null|string|array $initialValues
     * Valores iniciais para a coleção de cookies.
     *
     * @return iCookieCollection
     */
    public function createCookieCollection(null|string|array $initialValues = null): iCookieCollection
    {
        if (\is_string($initialValues) === true) {
            return \AeonDigital\Http\Data\CookieCollection::fromString($initialValues);
        } elseif (\is_array($initialValues) === true) {
            return new \AeonDigital\Http\Data\CookieCollection($initialValues);
        } else {
            return new \AeonDigital\Http\Data\CookieCollection();
        }
    }
    /**
     * Retorna uma coleção de headers baseado nos valores passados.
     *
     * O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iQueryStringCollection``.
     *
     * @param null|string|array $initialValues
     * Valores iniciais para a coleção de cookies.
     *
     * @return iQueryStringCollection
     */
    public function createQueryStringCollection(null|string|array $initialValues = null): iQueryStringCollection
    {
        if (\is_string($initialValues) === true) {
            return \AeonDigital\Http\Data\QueryStringCollection::fromString($initialValues);
        } elseif (\is_array($initialValues) === true) {
            return new \AeonDigital\Http\Data\QueryStringCollection($initialValues);
        } else {
            return new \AeonDigital\Http\Data\QueryStringCollection();
        }
    }
    /**
     * Retorna uma coleção de headers baseado nos valores passados.
     *
     * O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iFileCollection``.
     *
     * @param ?array $initialValues
     * Valores iniciais para a coleção de cookies.
     *
     * @return iFileCollection
     */
    public function createFileCollection(?array $initialValues = null): iFileCollection
    {
        return new \AeonDigital\Http\Data\FileCollection($initialValues);
    }
    /**
     * Retorna um objeto ``iCollection`` vazio.
     *
     * O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Collection\iCollection``.
     *
     * @param ?array $initialValues
     * Valores com os quais a instância deve iniciar.
     *
     * @param bool $autoincrement
     * Quando ``true`` permite que seja omitido o nome da chave dos valores pois
     * eles serão definidos internamente conforme fosse um array começando em zero.
     *
     * @return iCollection
     */
    public function createCollection(?array $initialValues = [], bool $autoincrement = false): iCollection
    {
        return new \AeonDigital\Collection\Collection($initialValues, $autoincrement);
    }










    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Uri\iUrl``.
     *
     * @param string $uri
     * Uri.
     *
     * @return iUrl
     *
     * @throws \InvalidArgumentException
     * Caso a ``uri`` passada seja inválida.
     */
    public function createUri(string $uri = ""): iUrl
    {
        return \AeonDigital\Http\Uri\Url::fromString($uri);
    }










    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
     *
     * @param string $content
     * Conteúdo inicial.
     *
     * @return iStream
     */
    public function createStream(string $content = ""): iStream
    {
        $useStream = \fopen("php://temp", "r+");
        \fwrite($useStream, $content);

        return new \AeonDigital\Http\Stream\Stream($useStream);
    }
    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iFileStream``.
     *
     * @param string $filename
     * Caminho completo até o arquivo.
     *
     * @param string $mode
     * Modo no qual o stream será aberto.
     *
     * @return iFileStream
     */
    public function createStreamFromFile(string $filename, string $mode = "r"): iFileStream
    {
        return new \AeonDigital\Http\Stream\FileStream($filename, $mode);
    }
    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
     *
     * @param resource $resource
     * Recurso que será aberto no stream.
     *
     * @return iStream
     */
    public function createStreamFromResource($resource): iStream
    {
        return new \AeonDigital\Http\Stream\Stream($resource);
    }
    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
     *
     * O objeto criado deve ser baseado no ``stream`` do ``body`` da requisição que está
     * ocorrendo no momento.
     *
     * @return iStream
     */
    public function createStreamFromBodyRequest(): iStream
    {
        $reqBody = \fopen("php://temp", "w+");
        \stream_copy_to_stream(\fopen("php://input", "r"), $reqBody);
        \rewind($reqBody);

        return $this->createStreamFromResource($reqBody);
    }










    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iRequest``.
     *
     * @param string $httpMethod
     * Método ``Http`` que está sendo usado para a requisição.
     *
     * @param string $uri
     * ``URI`` que está sendo executada.
     *
     * @param ?string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param ?iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da requisição.
     *
     * @param ?iStream $body
     * Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @return iRequest
     *
     * @throws \InvalidArgumentException
     * Caso algum dos argumentos passados seja inválido.
     */
    public function createRequest(
        string $httpMethod,
        string $uri,
        ?string $httpVersion = null,
        ?iHeaderCollection $headers = null,
        ?iStream $body = null
    ): iRequest {
        $httpMethod = (($httpMethod === "") ? "GET" : $httpMethod);
        $uri = $this->createUri($uri);
        $httpVersion = (($httpVersion === null || $httpVersion === "") ? "1.1" : $httpVersion);
        $headers = (($headers === null) ? $this->createHeaderCollection() : $headers);
        $body = (($body === null) ? $this->createStreamFromBodyRequest() : $body);

        return new \AeonDigital\Http\Message\Request($httpMethod, $uri, $httpVersion, $headers, $body);
    }





    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iServerRequest``.
     *
     * @param string $httpMethod
     * Método ``Http`` que está sendo usado para a requisição.
     *
     * @param string $uri
     * ``URI`` que está sendo executada.
     *
     * @param ?string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param ?iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da requisição.
     *
     * @param ?iStream $body
     * Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param ?iCookieCollection $cookies
     * Objeto que implementa ``iCookieCollection`` cotendo os cookies da requisição.
     *
     * @param ?iQueryStringCollection $queryStrings
     * Objeto que implementa ``iQueryStringCollection`` cotendo os queryStrings da ``URI``.
     *
     * @param ?iFileCollection $files
     * Objeto que implementa ``iFileCollection`` cotendo os arquivos enviados nesta
     * requisição.
     *
     * @param ?array $serverParans
     * Coleção de parametros definidos pelo servidor sobre o ambiente e requisição
     * atual.
     *
     * @param ?iCollection $attributes
     * Objeto que implementa ``iCollection`` cotendo atributos personalizados para
     * esta requisição.
     *
     * @param ?iCollection $bodyParsers
     * Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar
     * o processamento do body da requisição.
     *
     * @return iServerRequest
     *
     * @throws \InvalidArgumentException
     * Caso algum dos argumentos passados seja inválido.
     */
    public function createServerRequest(
        string $httpMethod,
        string $uri,
        ?string $httpVersion = null,
        ?iHeaderCollection $headers = null,
        ?iStream $body = null,
        ?iCookieCollection $cookies = null,
        ?iQueryStringCollection $queryStrings = null,
        ?iFileCollection $files = null,
        ?array $serverParans = null,
        ?iCollection $attributes = null,
        ?iCollection $bodyParsers = null
    ): iServerRequest {
        $httpMethod = (($httpMethod === "") ? "GET" : $httpMethod);
        $uri = $this->createUri($uri);
        $httpVersion = (($httpVersion === null || $httpVersion === "") ? "1.1" : $httpVersion);
        $headers = (($headers === null) ? $this->createHeaderCollection() : $headers);
        $body = (($body === null) ? $this->createStreamFromBodyRequest() : $body);
        $cookies = (($cookies === null) ? $this->createCookieCollection() : $cookies);
        $queryStrings = (($queryStrings === null) ? $this->createQueryStringCollection() : $queryStrings);
        $files = (($files === null) ? $this->createFileCollection() : $files);
        $serverParans = (($serverParans === null) ? [] : $serverParans);
        $attributes = (($attributes === null) ? $this->createCollection() : $attributes);
        $bodyParsers = (($bodyParsers === null) ? $this->createCollection() : $bodyParsers);



        // Une as duas coleções de querystrings e normaliza ambos objetos.
        if ($queryStrings->toString() !== $uri->getQuery()) {
            $uriQS = [];
            \parse_str($uri->getQuery(), $uriQS);

            $useQS = \http_build_query(\array_merge($uriQS, $queryStrings->toArray()));
            $uri = $uri->withQuery($useQS);
            $queryStrings = $this->createQueryStringCollection($useQS);
        }



        return new \AeonDigital\Http\Message\ServerRequest(
            $httpMethod,
            $uri,
            $httpVersion,
            $headers,
            $body,
            $cookies,
            $queryStrings,
            $files,
            $serverParans,
            $attributes,
            $bodyParsers
        );
    }





    /**
     * Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iResponse``.
     *
     * @param int $statusCode
     * Código do status ``Http``.
     *
     * @param string $reasonPhrase
     * Frase razão do status ``Http``.
     * Se não for definida e o código informado for um código padrão, usará a frase
     * razão correspondente.
     *
     * @param ?string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param ?iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection``
     * cotendo os cabeçalhos da requisição.
     *
     * @param ?iStream $body
     * Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param ?\StdClass $viewData
     * Objeto ``viewData``.
     *
     * @param ?string $mime
     * Mimetype que deve ser usado para criar o corpo da mensagem.
     *
     * @param ?string $locale
     * Locale no qual a informação que consta no corpo da mensagem está construído.
     *
     * @return iResponse
     *
     * @throws \InvalidArgumentException
     * Caso algum dos argumentos passados seja inválido.
     */
    public function createResponse(
        int $statusCode = 200,
        string $reasonPhrase = "",
        ?string $httpVersion = null,
        ?iHeaderCollection $headers = null,
        ?iStream $body = null,
        ?\StdClass $viewData = null,
        ?string $mime = null,
        ?string $locale = null
    ): iResponse {
        $httpVersion = (($httpVersion === null || $httpVersion === "") ? "1.1" : $httpVersion);
        $headers = (($headers === null) ? $this->createHeaderCollection() : $headers);
        $body = (($body === null) ? $this->createStream() : $body);


        return new \AeonDigital\Http\Message\Response(
            $statusCode,
            $reasonPhrase,
            $httpVersion,
            $headers,
            $body,
            $viewData,
            $mime,
            $locale
        );
    }
}
