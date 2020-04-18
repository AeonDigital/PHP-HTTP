<?php
declare (strict_types=1);

namespace AeonDigital\Http\Message;

use AeonDigital\Interfaces\Http\Message\iResponse as iResponse;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;
use AeonDigital\Http\Message\Abstracts\aMessage as aMessage;



/**
 * Representa uma resposta ``HTTP`` à uma requisição feita por um ``UA``.
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * Implementação AeonDigital da interface ``Psr\Http\Message\ResponseInterface``.
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
    use \AeonDigital\Http\Traits\HTTPRawStatusCode;






    /**
     * Retorna um clone da instância atual e toma cuidado para clonar também qualquer objeto
     * interno que ela possua.
     *
     * @param       ?iHeaderCollection $useHeaders
     *              Objeto ``header`` para o clone.
     *
     * @param       ?iStream $useBody
     *              Objeto ``body`` para o clone.
     *
     * @param       ?\StdClass $useViewData
     *              Objeto ``viewData`` para o clone.
     *
     * @param       ?\StdClass $useViewConfig
     *              Objeto ``viewConfig`` para o clone.
     *
     * @return      static
     */
    private function cloneThisInstance(
        ?iHeaderCollection $useHeaders = null,
        ?iStream $useBody = null,
        ?\StdClass $useViewData = null,
        ?\StdClass $useViewConfig = null
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
     * @param       ?array $headers
     *              Coleção de headers a serem incorporados.
     *
     * @param       bool $merge
     *              Indica se é para mesclar ou substituir os headers presentes no momento.
     *
     * @return      ?iHeaderCollection
     */
    private function cloneHeaders(
        ?array $headers,
        bool $merge = false
    ) : ?iHeaderCollection {
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
     * Código do status ``HTTP`` desta instância.
     *
     * @var         int
     */
    protected int $statusCode;
    /**
     * Retorna o código do status ``HTTP`` que está definido para esta resposta.
     *
     * @return      int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }





    /**
     * Verifica se o ``statusCode`` indicado é válido.
     *
     * @param       string $statusCode
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma exception em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``statusCode`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateStatusCode($statusCode, bool $throw = false) : bool
    {
        $this->mainCheckForInvalidArgumentException(
            "statusCode", $statusCode, [
                ["validate" => "is integer"],
                [
                    "validate" => "closure",
                    "closure" => function($arg) {
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
     * @param       int $code
     *              Código do status ``HTTP`` a ser definido para a instância.
     *
     * @param       string $reasonPhrase
     *              Frase razão do status a ser enviada em conjunto na resposta.
     *              Se não for definida e o código informado for um código padrão, usará a frase
     *              razão correspondente.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``code``.
     */
    public function withStatus($code, $reasonPhrase = "")
    {
        $this->validateStatusCode($code, true);

        $clone = $this->cloneThisInstance();
        $clone->statusCode = $code;
        $clone->reasonPhrase = $reasonPhrase;


        if ($reasonPhrase === "" && isset(self::$rawStatusCode[$code]) === true) {
            $clone->reasonPhrase = self::$rawStatusCode[$code];
        }

        return $clone;
    }










    /**
     * Frase razão a ser usada ao enviar esta resposta.
     *
     * @var         string
     */
    protected string $reasonPhrase = "";
    /**
     * Retorna a ``frase razão`` para o código de status definido nesta instância.
     *
     * @return      string
     */
    public function getReasonPhrase() : string
    {
        return $this->reasonPhrase;
    }










    /**
     * Objeto ``viewData`` contendo as informações obtidas durante o processamento da rota alvo.
     *
     * @var         ?\StdClass
     */
    protected ?\StdClass $viewData = null;
    /**
     * Retorna o objeto ``viewData`` contendo as informações obtidas durante o processamento da
     * rota alvo.
     *
     * Este objeto traz dados a serem usados no corpo da view.
     *
     * @return      ?\StdClass
     */
    public function getViewData() : ?\StdClass
    {
        return $this->viewData;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewData`` especificado.
     *
     * @param       ?\StdClass $viewData
     *              Objeto ``viewData``.
     *
     * @return      iResponse
     */
    public function withViewData(?\StdClass $viewData) : iResponse
    {
        return $this->cloneThisInstance(null, null, $viewData);
    }










    /**
     * Objeto ``viewConfig`` contendo as informações obtidas durante o processamento da rota alvo.
     *
     * @var         ?\StdClass
     */
    protected ?\StdClass $viewConfig = null;
    /**
     * Retorna o objeto ``viewConfig`` contendo as informações obtidas durante o processamento da
     * rota alvo.
     *
     * Este objeto traz dados que orientam a criação da view.
     *
     * @return      ?\StdClass
     */
    public function getViewConfig() : ?\StdClass
    {
        return $this->viewConfig;
    }
    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewConfig`` especificado.
     *
     * @param       ?\StdClass $viewConfig
     *              Objeto ``viewConfig``.
     *
     * @return      iResponse
     */
    public function withViewConfig(?\StdClass $viewConfig) : iResponse
    {
        return $this->cloneThisInstance(null, null, null, $viewConfig);
    }










    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo os ``headers`` especificados.
     *
     * @param       array $headers
     *              Coleção de headers.
     *
     * @param       bool $merge
     *              Quando ``true`` irá manter os headers já definidos e apenas adicionar ou
     *              sobrescrever os definidos em ``$headers``.
     *
     * @return      iResponse
     */
    public function withHeaders(array $headers, bool $merge = false) : iResponse
    {
        return $this->cloneThisInstance($this->cloneHeaders($headers, $merge));
    }










    /**
     * Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
     * contendo o ``viewData`` e o ``viewConfig`` especificados.
     *
     * @param       ?\StdClass $viewData
     *              Objeto ``viewData``.
     *
     * @param       ?\StdClass $viewConfig
     *              Objeto ``viewConfig``.
     *
     * @param       ?array $headers
     *              Coleção de headers.
     *              Irá executar um Merge com os headers existentes.
     *
     * @return      iResponse
     */
    function withActionProperties(
        ?\StdClass $viewData,
        ?\StdClass $viewConfig,
        ?array $headers
    ) : iResponse {
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
     * @param       int $statusCode
     *              Código do status ``HTTP``.
     *
     * @param       string $reasonPhrase
     *              Frase razão do status ``HTTP``.
     *              Se não for definida e o código informado for um código padrão, usará a frase
     *              razão correspondente.
     *
     * @param       string $httpVersion
     *              Versão do protocolo ``HTTP``.
     *
     * @param       iHeaderCollection $headers
     *              Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da
     *              requisição.
     *
     * @param       iStream $body
     *              Objeto ``stream`` que faz parte do corpo da mensagem.
     *
     * @param       ?\StdClass $viewData
     *              Objeto ``viewData``.
     *
     * @param       ?\StdClass $viewConfig
     *              Objeto ``viewConfig``.
     *
     * @throws      \InvalidArgumentException
     */
    function __construct(
        int $statusCode,
        string $reasonPhrase,
        string $httpVersion,
        iHeaderCollection $headers,
        iStream $body,
        ?\StdClass $viewData = null,
        ?\StdClass $viewConfig = null
    ) {
        parent::__construct($httpVersion, $headers, $body);

        $this->validateStatusCode($statusCode, true);

        $this->statusCode   = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->viewData     = $viewData;
        $this->viewConfig   = $viewConfig;

        if ($reasonPhrase === "" && isset(self::$rawStatusCode[$statusCode]) === true) {
            $this->reasonPhrase = self::$rawStatusCode[$statusCode];
        }
    }
}
