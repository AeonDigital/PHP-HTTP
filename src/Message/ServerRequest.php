<?php
declare (strict_types=1);

namespace AeonDigital\Http\Message;

use AeonDigital\Interfaces\Http\Message\iServerRequest as iServerRequest;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Http\Uri\iUrl as iUrl;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Interfaces\Http\Data\iFileCollection as iFileCollection;
use AeonDigital\Interfaces\Http\Data\iCookieCollection as iCookieCollection;
use AeonDigital\Interfaces\Http\Data\iQueryStringCollection as iQueryStringCollection;
use AeonDigital\Interfaces\Collection\iCollection as iCollection;
use AeonDigital\Http\Message\Request as Request;





/**
 * Encapsula todos os objetos que representam na totalidade uma requisição recebida pelo servidor.
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * Implementação AeonDigital da interface ``Psr\Http\Message\ServerRequestInterface``.
 *
 * @see         http://www.php-fig.org/psr/
 *
 * @package     AeonDigital\Http\Message
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class ServerRequest extends Request implements iServerRequest
{
    use \AeonDigital\Http\Traits\ParseQualityHeaders;
    use \AeonDigital\Http\Traits\MimeTypeData;





    /**
     * Data e hora do instante da criação desta instância.
     *
     * @var         \DateTime
     */
    protected \DateTime $now;



    /**
     * Informações do servidor.
     *
     * @var         array
     */
    protected array $serverParans = [];



    /**
     * Coleção de cookies enviados pelo ``UA``.
     *
     * @var         iCookieCollection
     */
    protected iCookieCollection $cookies;



    /**
     * Coleção de querystrings enviados pelo ``UA``.
     *
     * @var         iQueryStringCollection
     */
    protected iQueryStringCollection $queryStrings;



    /**
     * Coleção de arquivos enviados pelo ``UA``.
     *
     * @var         iFileCollection
     */
    protected iFileCollection $files;



    /**
     * Tipo de valor definido para o ``body`` da requisição.
     *
     * @var         ?string
     */
    protected ?string $contentType = null;


    /**
     * Separador definido para requisições que sejam do tipo ``multipart/form-data``.
     * Este valor será usado para separar cada campo enviado em formulários
     * ``multipart/form-data``;
     *
     * @var         ?string
     */
    protected ?string $boundary = null;


    /**
     * Coleção de valores submetidos via body.
     * O valor ``null`` indica que nenhum foi enviado
     *
     * @var         ?array
     */
    protected $parsedBody = null;



    /**
     * Indica quando o ``body`` da instância já foi submetido ao processo de ``parse``.
     *
     * @var         bool
     */
    protected bool $hasParsedBody = false;



    /**
     * Coleção de atributos personalizados para a requisição.
     *
     * @var         iCollection
     */
    protected iCollection $attributes;



    /**
     * Coleção de ``closures`` que tem a responsabilidade de processar o ``body`` da requisição
     * e retornar o resultado do processamento que só pode ser ``null``, ``array`` ou ``object``.
     *
     * A chave identificadora de cada closure **DEVE SER** o mimetype ao qual ela é capaz de
     * tratar.
     *
     * No caso desta coleção ser ``null``, vazia ou de não haver um item que corresponda ao
     * mimetype indicado será acionada a função ``$this->internalParseBody()`` desta classe que
     * tem capacidade de tratar ``bodys`` que venham em ``json``, ``urlencode`` e ``xml``.
     *
     * As Closures da coleção precisam ser compativel com o seguinte esquema:
     * ``` php
     *  function $closure (string $body) : mixed
     * ```
     *
     * @var         ?iCollection
     */
    protected ?iCollection $bodyParsers;





    /**
     * Retorna a data e hora do instante em que a instância foi criada.
     *
     * @return      \DateTime
     */
    public function getNow() : \DateTime
    {
        return $this->now;
    }










    /**
     * Retorna um clone da instância atual e toma cuidado para clonar também qualquer objeto
     * interno que ela possua.
     *
     * @param       ?iUrl $useUri
     *              Objeto ``iUrl`` para o clone.
     *
     * @param       ?iHeaderCollection $useHeaders
     *              Objeto ``header`` para o clone.
     *
     * @param       ?iStream $useBody
     *              Objeto ``body`` para o clone.
     *
     * @param       ?iCookieCollection $useCookies
     *              Objeto ``cookies`` para o clone.
     *
     * @param       ?iQueryStringCollection $useQuery
     *              Objeto ``queryStrings`` para o clone.
     *
     * @param       ?iFileCollection $useFiles
     *              Objeto ``files`` para o clone.
     *
     * @param       ?iCollection $useAttributes
     *              Objeto ``attributes`` para o clone.
     *
     * @param       ?iCollection $useBodyParsers
     *              Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar o
     *              processamento do body da requisição.

     * @return      static
     */
    protected function cloneThisInstance(
        ?iUrl $useUri = null,
        ?iHeaderCollection $useHeaders = null,
        ?iStream $useBody = null,
        ?iCookieCollection $useCookies = null,
        ?iQueryStringCollection $useQuery = null,
        ?iFileCollection $useFiles = null,
        ?iCollection $useAttributes = null,
        ?iCollection $useBodyParsers = null
    ) {
        $clone = clone $this;

        $clone->uri = (($useUri === null) ? clone $this->uri : $useUri);
        $clone->headers = (($useHeaders === null) ? clone $this->headers : $useHeaders);
        $clone->body = (($useBody === null) ? clone $this->body : $useBody);
        $clone->cookies = (($useCookies === null) ? clone $this->cookies : $useCookies);
        $clone->queryStrings = (($useQuery === null) ? clone $this->queryStrings : $useQuery);
        $clone->files = (($useFiles === null) ? clone $this->files : $useFiles);
        $clone->attributes = (($useAttributes === null) ? clone $this->attributes : $useAttributes);

        if ($clone->bodyParsers !== null) {
            $clone->bodyParsers = (($useBodyParsers === null) ? clone $this->bodyParsers : $useBodyParsers);
        }

        return $clone;
    }





    /**
     * Retorna os parametros de configuração do servidor para a requisição atual.
     *
     * @return      array
     */
    public function getServerParams() : array
    {
        return $this->serverParans;
    }










    /**
     * Retorna os cookies enviados pelo ``UA``.
     *
     * Será retornado um array associativo contendo chave/valor de cada cookie recebido.
     *
     * @return      array
     */
    public function getCookieParams() : array
    {
        $r = [];
        foreach ($this->cookies->toArray(false) as $k => $v) {
            $r[$k] = $v->getValue();
        }
        return $r;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os objetos ``cookies`` especificado.
     *
     * @param       array $cookies
     *              Array associativo de cookies para serem usados pela nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``cookies``.
     */
    public function withCookieParams(array $cookies)
    {
        $clone = $this->cloneThisInstance();
        $clone->cookies->clean();
        $clone->cookies->insert($cookies);
        $clone->redefineParans();

        return $clone;
    }










    /**
     * Retorna os querystrings enviados pelo ``UA``.
     *
     * Será retornado um array associativo contendo chave/valor de cada querystring recebido.
     *
     * @return      array
     */
    public function getQueryParams() : array
    {
        $this->queryStrings->usePercentEncode(false);
        $r = $this->queryStrings->toArray(true);
        $this->queryStrings->usePercentEncode(true);

        return $r;
    }
    /**
     * Retorna o valor da querystring de nome indicado.
     * Retornará ``null`` caso ela não exista.
     *
     * @param       string $name
     *              Nome da querystring alvo.
     *
     * @return      ?string
     */
    public function getQueryString(string $name) : ?string
    {
        return $this->queryStrings->get($name);
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os objetos ``querystrings`` especificado.
     *
     * @param       array $query
     *              Array associativo de querystrings para serem usados pela nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``query``.
     */
    public function withQueryParams(array $query)
    {
        $cloneUri = $this->uri->withQuery(\http_build_query($query));

        $clone = $this->cloneThisInstance($cloneUri);
        $clone->queryStrings->clean();
        $clone->queryStrings->insert($query);
        $clone->redefineParans();

        return $clone;
    }










    /**
     * Retorna os arquivos enviados pelo ``UA``.
     *
     * @return      array
     */
    public function getUploadedFiles() : ?array
    {
        return $this->files->toArray(true);
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os arquivos especificado.
     *
     * @param       array $uploadedFiles
     *              Array associativo de arquivos para serem usados pela nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``uploadedFiles``.
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $clone = $this->cloneThisInstance();
        $clone->files->clean();
        $clone->files->insert($uploadedFiles);

        return $clone;
    }










    /**
     * Retorna um array contendo todos os campos recebidos no corpo da requisição.
     *
     * Trata-se de um alias para o método ``getParsedBody``.
     *
     * @return      ?array
     */
    public function getPostedFields() : ?array
    {
        return $this->getParsedBody();
    }



    /**
     * Retorna o valor do campo de nome indicado.
     * Retornará ``null`` caso ele não exista.
     *
     * @param       string $name
     *              Nome do campo alvo.
     *
     * @return      ?string
     */
    public function getPost(string $name) : ?string
    {
        $r = null;
        if ($this->contentType === "multipart/form-data" ||
            $this->contentType === "application/x-www-form-urlencoded") {
            $r = ((isset($this->parsedBody[$name]) === true) ? (string)$this->parsedBody[$name] : null);
        }
        return $r;
    }










    /**
     * Retorna o valor do cookie de nome indicado.
     * Retornará ``null`` caso ele não exista.
     *
     * @param       string $name
     *              Nome do cookie alvo.
     *
     * @return      ?string
     */
    public function getCookie(string $name) : ?string
    {
        return (($this->cookies->has($name) === true) ? $this->cookies->get($name)->getValue() : null);
    }










    /**
     * Armazena uma coleção de dados enviados pelo ``UA``.
     * Os dados são adicionados usando a seguinte ordem:
     *
     * - Valores de querystrings.
     * - Valores de campos enviados no corpo da requisição.
     * - Cookies
     *
     * Chaves de mesmo nome são sobrescritas na ordem apresentada.
     */
    protected ?array $parans = null;
    /**
     * Redefine a propriedade ``parans`` para estar de acordo com os dados definidos para a
     * instância.
     *
     * @return      void
     */
    private function redefineParans() :void
    {
        $postDataArr = [];
        if ($this->contentType === "multipart/form-data" ||
            $this->contentType === "application/x-www-form-urlencoded") {
            $postDataArr = ((\is_array($this->parsedBody) === true) ? $this->parsedBody : []);
        }


        $cookies = $this->cookies->toArray();
        $cookieArr = [];
        foreach ($cookies as $cookie) {
            $cookieArr[$cookie->getName()] = $cookie->getValue();
        }

        $this->parans = \array_merge(
            $postDataArr,
            $this->queryStrings->toArray(true),
            $this->attributes->toArray(),
            $cookieArr
        );
    }
    /**
     * Retorna o valor do parametro da requisição de nome indicado.
     * A chave é procurada entre Cookies, Attributes, QueryStrings e Post Data respectivamente e
     * será retornada a primeira entre as coleções avaliadas.
     *
     * Retornará ``null`` caso o nome da chave não seja encontrado.
     *
     * @param       string $name
     *              Nome do campo que está sendo requerido.
     *
     * @return      ?string
     */
    public function getParam(string $name)
    {
        if ($this->parans === null) {
            $this->redefineParans();
        }
        return ((isset($this->parans[$name]) === true) ? $this->parans[$name] : null);
    }










    /**
     * Inicia um novo objeto ``ServerRequest``.
     *
     * @param       string $httpMethod
     *              Método ``HTTP`` que está sendo usado para a requisição.
     *
     * @param       iUrl $uri
     *              Objeto que implementa a interface ``iUrl`` configurado com a ``URI`` que está
     *              sendo requisitada pelo ``UA``.
     *
     * @param       string $httpVersion
     *              Versão do protocolo ``HTTP``.
     *
     * @param       iHeaderCollection $headers
     *              Objeto que implementa ``iHeaderCollection``
     *              cotendo os cabeçalhos da requisição.
     *
     * @param       iStream $body
     *              Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param       iCookieCollection $cookies
     *              Objeto que implementa ``iCookieCollection`` cotendo os cookies da requisição.
     *
     * @param       iQueryStringCollection $queryStrings
     *              Objeto que implementa ``iQueryStringCollection`` cotendo os queryStrings.
     *
     * @param       iFileCollection $files
     *              Objeto que implementa ``iFileCollection`` cotendo os arquivos enviados nesta
     *              requisição.
     *
     * @param       array $serverParans
     *              Coleção de parametros definidos pelo servidor sobre o ambiente e requisição
     *              atual.
     *
     * @param       iCollection $attributes
     *              Objeto que implementa ``iCollection`` contendo atributos personalizados para
     *              esta requisição.
     *
     * @param       ?iCollection $bodyParsers
     *              Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar
     *              o processamento do body da requisição.
     *
     * @throws      \InvalidArgumentException
     *
     * @throws      \RuntimeException
     */
    function __construct(
        string $httpMethod,
        iUrl $uri,
        string $httpVersion,
        iHeaderCollection $headers,
        iStream $body,
        iCookieCollection $cookies,
        iQueryStringCollection $queryStrings,
        iFileCollection $files,
        array $serverParans,
        iCollection $attributes,
        ?iCollection $bodyParsers = null
    ) {
        parent::__construct($httpMethod, $uri, $httpVersion, $headers, $body);
        $this->now = new \DateTime();

        $this->cookies = $cookies;
        $this->queryStrings = $queryStrings;
        $this->files = $files;
        $this->serverParans = $serverParans;
        $this->attributes = $attributes;
        $this->bodyParsers = $bodyParsers;



        if ($this->queryStrings->toString() !== $uri->getQuery()) {
            throw new \RuntimeException("Incorrect querystring set.");
        }
        $this->queryStrings->usePercentEncode(false);


        $cttType = $this->headers->get("Content-Type");
        $cttType = (($cttType !== null && \count($cttType) > 0) ? $cttType[0] : null);
        if ($cttType !== null && \strpos($cttType, ";") !== false) {
            $cttTypeVal = \array_map("trim", \explode(";", (string)$cttType));
            $cttType = $cttTypeVal[0];

            if (\strpos($cttTypeVal[1], "boundary=") !== false) {
                $this->boundary = \str_replace("boundary=", "", $cttTypeVal[1]);
            }
        }
        $this->contentType = $cttType;


        $this->getParsedBody();

        $useHttpMethod = $this->getParam("_method");
        if ($useHttpMethod !== null) {
            $this->method = $this->checkMethod($useHttpMethod);
        }
    }





    /**
     * Irá processar o ``body`` da requisição caso esteja sendo tratado de um ``json``, ``xml``
     * ou ``urlencode``.
     *
     * Retornará ``null`` caso não seja possível efetuar o processamento.
     *
     * Esta função é acionada quando nenhuma closure existente na coleção ``$this->bodyParsers``
     * corresponde ao mimetype requerido ou quando a própria coleção é ``null``.
     *
     * @param       string $body
     *              String representando o ``body`` da requisição em seu formato ``raw``.
     *
     * @param       string $mime
     *              Mimetype do conteúdo.
     *
     * @param       string $boundary
     *              String que define o limite de campos enviados por formulários
     *              ``multipart/form-data``
     *
     * @return      null|array|object
     */
    protected function internalParseBody(string $body, string $mime, string $boundary)
    {
        $r = null;
        $useType = $mime;

        $parts = \explode("/", $useType);
        if (\count($parts) >= 2) {
            $useType = $parts[\count($parts) - 1];
        }

        $parts = \explode("+", $useType);
        if (\count($parts) >= 2) {
            $useType = $parts[\count($parts) - 1];
        }



        switch ($useType) {
            case "json":
                $r = \json_decode($body, true);
                if (\is_array($r) === false) {
                    $r = null;
                }

                break;

            case "xml":
                $backup = \libxml_disable_entity_loader(true);
                $backup_errors = \libxml_use_internal_errors(true);
                $r = \simplexml_load_string($body);
                \libxml_disable_entity_loader($backup);
                \libxml_clear_errors();
                \libxml_use_internal_errors($backup_errors);

                if ($r === false) {
                    $r = null;
                }

                break;

            case "form-data":
            case "x-www-form-urlencoded":
                if ($boundary === "") {
                    \parse_str($body, $r);
                }
                else {

                    $multipartDataFields = \preg_split("/-+$boundary/", $body);
                    \array_pop($multipartDataFields);
                    $selectedUploadedFiles = [];

                    foreach ($multipartDataFields as $i => $rawFieldData) {
                        $fieldData = $this->parseMultipartField($rawFieldData);

                        if ($fieldData !== null) {
                            \extract($fieldData);

                            if ($fieldFile === null) {
                                if (\ends_with($fieldName, "[]") === true) {
                                    if (isset($r[$fieldName]) === false) { $r[$fieldName] = []; }
                                    $r[$fieldName][] = $fieldValue;
                                }
                                else {
                                    $r[$fieldName] = $fieldValue;
                                }
                            }
                            else {
                                // prosseguir daqui e ver o que fazer quando um arquivo vier vazio.
                                $tempFile = \tempnam(\ini_get("upload_tmp_dir"), "tmp");
                                $bytes = \file_put_contents($tempFile, $fieldValue);
                                if ($bytes !== false) {
                                    if (isset($selectedUploadedFiles[$fieldName]) === false) {
                                        $selectedUploadedFiles[$fieldName] = [];
                                    }

                                    $selectedUploadedFiles[$fieldName][] = new \AeonDigital\Http\Data\File(
                                        new \AeonDigital\Http\Stream\FileStream($tempFile),
                                        $fieldFile,
                                        UPLOAD_ERR_OK
                                    );
                                }
                            }
                        }

                    }


                    foreach ($selectedUploadedFiles as $fieldName => $files) {
                        $this->files->set($fieldName, $files);
                    }
                }
                break;
        }


        return $r;
    }




    /**
     * Efetua o parse de campo postado em formulário ``multipart/form-data``.
     *
     * @param       string $rawFieldData
     *              Versão bruta dos dados do campo que será serializado.
     *
     * @return      ?array
     */
    private function parseMultipartField(string $rawFieldData) : ?array
    {
        $r = null;
        $lineSep = "\r\n";
        $rawFieldData = \substr_replace(\ltrim($rawFieldData), "", -2);

        if ($rawFieldData !== "") {

            $contentDisposition = null;
            $contentType = null;

            $fieldName = null;
            $fieldFile = null;
            $fieldMime = null;
            $fieldValue = "";

            $endOfFirstLine = \strpos($rawFieldData, $lineSep);
            if ($endOfFirstLine === false) {
                $contentDisposition = $rawFieldData;
            }
            else {
                $contentDisposition = \substr($rawFieldData, 0, $endOfFirstLine);
            }


            \preg_match('/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/i', $contentDisposition, $cdMatches);
            if (\count($cdMatches) > 0) {
                $fieldName = \trim($cdMatches[2]);

                if ($fieldName === "") {
                    $fieldName = null;
                }
                else {
                    $fieldFile = (\count($cdMatches) === 5) ? \trim($cdMatches[4]) : null;
                    if ($fieldFile === null && \strpos($contentDisposition, "; filename=\"") !== false) {
                        $fieldFile = "";
                    }

                    $c = 1;
                    if ($fieldFile === null) {
                        $fieldValue = \str_replace($contentDisposition . $lineSep . $lineSep, "", $rawFieldData, $c);
                    }
                    else {
                        $rawFieldData = \str_replace($contentDisposition . $lineSep, "", $rawFieldData, $c);
                        $endOfSecondLine = \strpos($rawFieldData, $lineSep);


                        if ($endOfSecondLine !== false) {
                            $contentType = \substr($rawFieldData, 0, $endOfSecondLine);

                            \preg_match('/content-type:([ \S]+)/i', $contentType, $ctMatches);
                            if (\count($ctMatches) > 0) {
                                $fieldMime = \trim($ctMatches[1]);
                                $fieldValue = \str_replace($ctMatches[0] . $lineSep . $lineSep, "", $rawFieldData, $c);
                            }
                        }
                    }
                }
            }


            if ($fieldName !== null) {
                $r = [
                    "fieldName" => $fieldName,
                    "fieldFile" => $fieldFile,
                    "fieldMime" => $fieldMime,
                    "fieldValue" => $fieldValue
                ];
            }
        }

        return $r;
    }





    /**
     * Retorna qualquer parametro enviado no ``body`` da requisição atual
     * em um formato adequado para ser consumido.
     *
     * Retornará ``null`` caso nenhum valor tenha sido submetido.
     *
     * @return      null|array|object
     */
    public function getParsedBody()
    {
        if ($this->hasParsedBody === false) {
            $this->hasParsedBody = true;

            $body = (string)$this->getBody();
            if ($this->bodyParsers === null || $this->bodyParsers->has((string)$this->contentType) === false) {
                $this->parsedBody = $this->internalParseBody(
                    $body,
                    (string)$this->contentType,
                    (string)$this->boundary
                );
            } else {
                $closure = $this->bodyParsers->get((string)$this->contentType);
                $this->parsedBody = $closure($body);
            }
        }

        return $this->parsedBody;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os arquivos especificado.
     *
     * @param       array $data
     *              Array associativo de arquivos para serem usados pela nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``uploadedFiles``.
     */
    public function withParsedBody($data)
    {
        $this->mainCheckForInvalidArgumentException(
            "data", $data, [
                [
                    "validate" => "closure",
                    "closure" => function($arg) {
                        return ($arg === null || \is_array($arg) === true || \is_object($arg) === true);
                    },
                    "customErrorMessage" => "Invalid value defined for \"data\". Expected an array assoc, object or ``null``.",
                    "showArgumentInMessage" => false
                ],
            ]
        );

        $clone = $this->cloneThisInstance();

        $clone->hasParsedBody = true;
        $clone->parsedBody = $data;
        $clone->redefineParans();

        return $clone;
    }










    /**
     * Coleção qualitativa de mimetypes que podem ser usados para responder a esta requisição.
     *
     * @var         ?array
     */
    protected ?array $responseMimes = null;
    /**
     * Retorna uma coleção de mimetypes que o ``UA`` definiu como opções válidas para responder
     * a esta requisição.
     *
     * Este valor é definido a partir da avaliação qualitativa do Header ``accept``.
     *
     * Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção de
     * valores válidos.
     * Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
     * ``accept``.
     *
     * @return      ?array
     * ``` php
     *  $arr = [
     *      ["mime" => "html", "mimetype" => "text/html"]
     *  ];
     * ```
     */
    public function getResponseMimes() : ?array
    {
        if ($this->responseMimes === null) {
            $rMimes     = \array_flip($this->responseMimeTypes);
            $qMimes     = $this->parseRawLineOfQualityHeaders($this->getHeaderLine("accept"));
            $useMimes   = [];

            if (\is_array($qMimes) === true) {
                foreach ($qMimes as $qualityMime) {
                    $mt = $qualityMime["value"];
                    if ($mt === "*/*") {
                        $useMimes[] = [
                            "mime"      => "*/*",
                            "mimetype"  => "*/*"
                        ];
                    }
                    else {
                        if (isset($rMimes[$mt]) === true) {
                            $useMimes[] = [
                                "mime"      => $rMimes[$mt],
                                "mimetype"  => $mt
                            ];
                        }
                    }
                }

                $this->responseMimes = $useMimes;
            }
        }

        return $this->responseMimes;
    }










    /**
     * Coleção qualificada de locales e languages que o ``UA`` definiu como aqueles que ele
     * prefere receber como resposta.
     *
     * @var         ?array
     */
    protected ?array $responseAcceptLanguage = null;
    /**
     * Retorna uma coleção de locales que o ``UA`` definiu como opções válidas para responder
     * a esta requisição.
     *
     * Este valor é definido a partir da avaliação qualitativa do Header ``accept-language``.
     *
     * Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção
     * de valores válidos.
     * Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
     * ``accept-language``.
     *
     * @return      ?array
     */
    public function getResponseLocales() : ?array
    {
        if ($this->responseAcceptLanguage === null) {
            $this->responseAcceptLanguage = $this->parseRawLineOfHeaderAcceptLanguage(
                $this->getHeaderLine("accept-language")
            );
        }

        return $this->responseAcceptLanguage["locales"];
    }
    /**
     * Retorna uma coleção de languages que o ``UA`` definiu como opções válidos para responder
     * a esta requisição.
     *
     * Este valor é definido a partir da avaliação qualitativa do Header ``accept-language``.
     *
     * Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção de
     * valores válidos.
     * Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
     * ``accept-language``.
     *
     * @return      ?array
     */
    public function getResponseLanguages() : ?array
    {
        if ($this->responseAcceptLanguage === null) {
            $this->responseAcceptLanguage = $this->parseRawLineOfHeaderAcceptLanguage(
                $this->getHeaderLine("accept-language")
            );
        }

        return $this->responseAcceptLanguage["languages"];
    }









    /**
     * Define uma coleção de atributos iniciais para a requisição atual.
     * Este método só pode ser utilizado 1 vez.
     *
     * Estes devem ser **SEMPRE** os primeiros atributos a serem definidos para a coleção.
     *
     * @param       array $attributes
     *              Array associativo contendo a coleção de atributos que serão definidos.
     *
     * @return      void
     */
    public function setInitialAttributes(array $attributes) : void
    {
        if ($this->attributes->count() === 0) {
            foreach ($attributes as $k => $v) {
                $this->attributes->set($k, $v);
            }
            $this->redefineParans();
        }
    }





    /**
     * Coleção de atributos da requisição.
     *
     * Os atributos de uma requisição podem ser valores variados como o resultado de uma
     * operação com o caminho requisitado, a decriptação de um cookie, o resultado da
     * desserialização de mensagens recebidas no body, etc.
     *
     * Diferente das demais propriedades deste tipo de classe, neste caso atributos **SÃO Mutáveis**!
     *
     * @return      array
     */
    public function getAttributes() : array
    {
        return $this->attributes->toArray();
    }
    /**
     * Retorna o valor de um determinado atributo da requisição a partir de seu nome.
     *
     * Caso aquele atributo não seja encontrado será retornado o valor definido em ``default``.
     *
     * @param       string $name
     *              O nome do atributo a ser retornado.
     *
     * @param       mixed $default
     *              Valor padrão para o atributo, caso não exista.
     *
     * @return      mixed
     */
    public function getAttribute($name, $default = null)
    {
        $r = $default;
        if ($this->attributes->has($name) === true) {
            $r = $this->attributes->get($name);
        }
        return $r;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os ``attributes`` especificados.
     *
     * @param       string $name
     *              Nome do atributo que será definido.
     *
     * @param       mixed $value
     *              Valor do atributo.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido.
     */
    public function withAttribute($name, $value)
    {
        $clone = $this->cloneThisInstance();
        $clone->attributes->set($name, $value);
        $clone->redefineParans();

        return $clone;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * sem o ``attribute`` especificado.
     *
     * @param       string $name
     *              Nome do atributo que será removido.
     *
     * @return      static
     */
    public function withoutAttribute($name)
    {
        $clone = $this->cloneThisInstance();
        $clone->attributes->remove($name);
        $clone->redefineParans();

        return $clone;
    }
}
