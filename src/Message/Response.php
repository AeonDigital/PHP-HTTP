<?php

declare(strict_types=1);

namespace AeonDigital\Http\Message;

use Psr\Http\Message\ResponseInterface as ResponseInterface;
use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Http\Message\Abstracts\aMessage as aMessage;
use AeonDigital\Iana\Iana as Iana;


/**
 * Representa uma resposta ``Http`` à uma requisição feita por um ``UA``.
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * Esta classe é compatível com a PSR ``Psr\Http\Message\ResponseInterface`` mas não a implementa
 * de forma direta. Use a classe ``PSRResponse`` ou o método ``toPSR`` para obter uma instância
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
class Response extends aMessage implements iResponse
{






    /**
     * Retorna um clone da instância atual e toma cuidado para clonar também qualquer objeto
     * interno que ela possua.
     *
     * @param ?iHeaderCollection $useHeaders
     * Objeto ``header`` para o clone.
     *
     * @param ?iStream $useBody
     * Objeto ``body`` para o clone.
     *
     * @param ?\stdClass $useViewData
     * Objeto ``viewData`` para o clone.
     *
     * @param ?\stdClass $useViewConfig
     * Objeto ``viewConfig`` para o clone.
     *
     * @return static
     */
    private function cloneThisInstance(
        ?iHeaderCollection $useHeaders = null,
        ?iStream $useBody = null,
        ?\stdClass $useViewData = null,
        ?\stdClass $useViewConfig = null
    ) {
        $clone = clone $this;

        $clone->headers = (($useHeaders === null) ? clone $this->headers : $useHeaders);
        $clone->body = (($useBody === null) ? clone $this->body : $useBody);

        if ($clone->viewData !== null || $useViewData !== null) {
            $clone->viewData = (($useViewData === null) ? clone $this->viewData : $useViewData);
        }

        if ($clone->viewConfig !== null || $useViewConfig !== null) {
            $clone->viewConfig = (($useViewConfig === null) ? clone $this->viewConfig : $useViewConfig);
        }

        return $clone;
    }
    /**
     * Efetua a clonagem da coleção de Headers presentes na presente instancia.
     *
     * @param ?array $headers
     * Coleção de headers a serem incorporados.
     *
     * @param bool $merge
     * Indica se é para mesclar ou substituir os headers presentes no momento.
     *
     * @return ?iHeaderCollection
     */
    private function cloneHeaders(
        ?array $headers,
        bool $merge = false
    ): ?iHeaderCollection {
        if ($headers === null) {
            return null;
        } else {
            $tmpHeaders = clone $this->headers;
            if ($merge === false) {
                $tmpHeaders->clean();
            }

            foreach ($headers as $key => $val) {
                $tmpHeaders->set($key, $val);
            }

            return $tmpHeaders;
        }
    }










    /**
     * Código do status ``Http`` desta instância.
     *
     * @var int
     */
    protected int $statusCode;
    /**
     * Retorna o código do status ``Http`` que está definido para esta resposta.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }





    /**
     * Verifica se o ``statusCode`` indicado é válido.
     *
     * @param string $statusCode
     * Valor que será testado.
     *
     * @param bool $throw
     * Quando ``true`` irá lançar uma exception em caso de falha.
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     * Caso o ``statusCode`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateStatusCode($statusCode, bool $throw = false): bool
    {
        $this->mainCheckForInvalidArgumentException(
            "statusCode",
            $statusCode,
            [
                ["validate" => "is integer"],
                [
                    "validate" => "closure",
                    "closure" => function ($arg) {
                        return ($arg >= 100 && $arg <= 599);
                    },
                    "customErrorMessage" => "Invalid value defined for \"statusCode\". Expected an integer between 100 and 599."
                ]
            ],
            $throw
        );
        return $this->getLastArgumentValidateResult();
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``method`` especificado.
     *
     * @param int $code
     * Código do status ``Http`` a ser definido para a instância.
     *
     * @param string $reasonPhrase
     * Frase razão do status a ser enviada em conjunto na resposta.
     * Se não for definida e o código informado for um código padrão, usará a frase
     * razão correspondente.
     *
     * @return static
     *
     * @throws \InvalidArgumentException
     * Caso seja definido um valor inválido para ``code``.
     */
    public function withStatus(int $code, string $reasonPhrase = ""): static
    {
        $this->validateStatusCode($code, true);

        $clone = $this->cloneThisInstance();
        $clone->statusCode = $code;
        $clone->reasonPhrase = $reasonPhrase;


        if ($reasonPhrase === "" && \key_exists($code, Iana::HTTPStatusCode) === true) {
            $clone->reasonPhrase = Iana::HTTPStatusCode[$code];
        }

        return $clone;
    }










    /**
     * Frase razão a ser usada ao enviar esta resposta.
     *
     * @var string
     */
    protected string $reasonPhrase = "";
    /**
     * Retorna a ``frase razão`` para o código de status definido nesta instância.
     *
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }










    /**
     * Objeto ``viewData`` contendo as informações obtidas durante o processamento da rota alvo.
     *
     * @var ?\stdClass
     */
    protected ?\stdClass $viewData = null;
    /**
     * Retorna o objeto ``viewData`` contendo as informações obtidas durante o processamento da
     * rota alvo.
     *
     * Este objeto traz dados a serem usados no corpo da view.
     *
     * @return ?\stdClass
     */
    public function getViewData(): ?\stdClass
    {
        return $this->viewData;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewData`` especificado.
     *
     * @param ?\stdClass $viewData
     * Objeto "viewData".
     *
     * @return static
     */
    public function withViewData(?\stdClass $viewData): static
    {
        return $this->cloneThisInstance(null, null, $viewData);
    }










    /**
     * Objeto ``viewConfig`` contendo as informações obtidas durante o processamento da rota alvo.
     *
     * @var ?\stdClass
     */
    protected ?\stdClass $viewConfig = null;
    /**
     * Retorna o objeto ``viewConfig`` contendo as informações obtidas durante o processamento da
     * rota alvo.
     *
     * Este objeto traz dados que orientam a criação da view.
     *
     * @return ?\stdClass
     */
    public function getViewConfig(): ?\stdClass
    {
        return $this->viewConfig;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewConfig`` especificado.
     *
     * @param ?\stdClass $viewConfig
     * Objeto "viewConfig".
     *
     * @return static
     */
    public function withViewConfig(?\stdClass $viewConfig): static
    {
        return $this->cloneThisInstance(null, null, null, $viewConfig);
    }










    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os ``headers`` especificados.
     *
     * @param array $headers
     * Coleção de headers.
     *
     * @param bool $merge
     * Quando ``true`` irá manter os headers já definidos e apenas adicionar ou
     * sobrescrever os definidos em ``$headers``.
     *
     * @return static
     */
    public function withHeaders(array $headers, bool $merge = false): static
    {
        return $this->cloneThisInstance($this->cloneHeaders($headers, $merge));
    }










    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewData`` e o ``viewConfig`` especificados.
     *
     * @param ?\stdClass $viewData
     * Objeto ``viewData``.
     *
     * @param ?\stdClass $viewConfig
     * Objeto ``viewConfig``.
     *
     * @param ?array $headers
     * Coleção de headers.
     * Irá executar um Merge com os headers existentes.
     *
     * @return iResponse
     */
    function withActionProperties(
        ?\stdClass $viewData,
        ?\stdClass $viewConfig,
        ?array $headers
    ): static {
        return $this->cloneThisInstance(
            $this->cloneHeaders($headers, true),
            null,
            $viewData,
            $viewConfig
        );
    }










    /**
     * Inicia um novo objeto ``Response``.
     *
     * @param int $statusCode
     * Código do status ``Http``.
     *
     * @param string $reasonPhrase
     * Frase razão do status ``Http``.
     * Se não for definida e o código informado for um código padrão, usará a frase
     * razão correspondente.
     *
     * @param string $httpVersion
     * Versão do protocolo ``Http``.
     *
     * @param iHeaderCollection $headers
     * Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da
     * requisição.
     *
     * @param iStream $body
     * Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param ?\stdClass $viewData
     * Objeto ``viewData``.
     *
     * @param ?\stdClass $viewConfig
     * Objeto ``viewConfig``.
     *
     * @throws \InvalidArgumentException
     */
    function __construct(
        int $statusCode,
        string $reasonPhrase,
        string $httpVersion,
        iHeaderCollection $headers,
        iStream $body,
        ?\stdClass $viewData = null,
        ?\stdClass $viewConfig = null
    ) {
        parent::__construct($httpVersion, $headers, $body);

        $this->validateStatusCode($statusCode, true);

        $this->statusCode   = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->viewData     = $viewData;
        $this->viewConfig   = $viewConfig;

        if ($reasonPhrase === "" && \key_exists($statusCode, Iana::HTTPStatusCode) === true) {
            $this->reasonPhrase = Iana::HTTPStatusCode[$statusCode];
        }
    }





    /**
     * Retorna uma instância deste mesmo objeto, porém, compatível com a interface
     * em que foi baseada ``Psr\Http\Message\ResponseInterface``.
     */
    public function toPSR(): ResponseInterface
    {
        return new \AeonDigital\Http\Message\PSRResponse(
            $this->statusCode,
            $this->reasonPhrase,
            $this->protocolVersion,
            $this->headers,
            $this->body->toPSR(),
            $this->viewData,
            $this->viewConfig
        );
    }
    /**
     * A partir de um objeto ``Psr\Http\Message\ResponseInterface``, retorna um novo que implementa
     * a interface ``AeonDigital\Interfaces\Http\Message\iResponse``.
     *
     * @param ResponseInterface $obj
     * Instância original.
     *
     * @return static
     * Nova instância, sob nova interface.
     *
     * @throws \InvalidArgumentException
     * Se por qualquer motivo não for possível retornar uma nova instância a partir da
     * que foi passada
     */
    public static function fromPSR(ResponseInterface $obj): static
    {
        $lineHeaders = [];
        foreach ($obj->getHeaders() as $name => $values) {
            $lineHeaders[] = $name . ": " . implode(", ", $values);
        }

        return new \AeonDigital\Http\Message\Response(
            $obj->getStatusCode(),
            $obj->getReasonPhrase(),
            $obj->getProtocolVersion(),
            \AeonDigital\Http\Data\HeaderCollection::fromString(\implode("\n", $lineHeaders)),
            \AeonDigital\Http\Stream\Stream::fromPSR($obj->getBody())
        );
    }
}
