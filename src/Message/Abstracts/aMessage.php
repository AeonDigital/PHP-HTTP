<?php
declare (strict_types=1);

namespace AeonDigital\Http\Message\Abstracts;

use Psr\Http\Message\MessageInterface as MessageInterface;
use Psr\Http\Message\StreamInterface as StreamInterface;
use AeonDigital\Interfaces\Stream\iStream as iStream;
use AeonDigital\Interfaces\Http\Data\iHeaderCollection as iHeaderCollection;





/**
 * Fornece as operações básicas para o uso de mensagens ``HTTP`` (request ou response).
 *
 * Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
 * seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
 * instância com a alteração necessária para o novo estado.
 *
 * Esta classe implementa a interface interface
 * ``Psr\Http\Message\MessageInterface``.
 *
 * @see         http://www.php-fig.org/psr/
 *
 * @see         http://www.ietf.org/rfc/rfc7230.txt
 *
 * @see         http://www.ietf.org/rfc/rfc7231.txt
 *
 * @package     AeonDigital\Http\Message
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
abstract class aMessage implements MessageInterface
{





    /**
     * Retorna um clone da instância atual e toma cuidado para
     * clonar também qualquer objeto interno que ela possua.
     *
     * @param       ?iHeaderCollection $useHeaders
     *              Objeto "header" para o clone.
     *
     * @param       ?iStream $useBody
     *              Objeto "body" para o clone.
     *
     * @return      static
     */
    private function cloneThisInstance(
        ?iHeaderCollection $useHeaders = null,
        ?iStream $useBody = null
    ) {
        $clone = clone $this;

        $clone->headers = (($useHeaders === null) ? clone $this->headers : $useHeaders);
        $clone->body = (($useBody === null) ? clone $this->body : $useBody);

        return $clone;
    }










    /**
     * Versão do protocolo HTTP da mensagem.
     *
     * @var         string
     */
    protected $protocolVersion = null;
    /**
     * Retorna a versão do protocolo HTTP sendo usado.
     *
     * @return      string
     */
    public function getProtocolVersion() : string
    {
        return $this->protocolVersion;
    }





    /**
     * Verifica se o "protocolVersion" indicado é válido.
     *
     * @param       string $protocolVersion
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando "true" irá lançar uma exception em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o "protocolVersion" definido seja inválido e $throw seja "true".
     */
    protected function validateProtocolVersion($protocolVersion, bool $throw = false) : bool
    {
        $r = (is_string($protocolVersion) === true);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"protocolVersion\" value. Must be an string.");
        } elseif (in_array($protocolVersion, ["1.0", "1.1", "2.0", "2"]) === false) {
            throw new \InvalidArgumentException("Invalid given \"protocolVersion\" value. [ \"" . $protocolVersion . "\" ].");
        }
        return $r;
    }
    /**
     * Este método DEVE manter o estado da instância atual e retornar
     * uma nova instância contendo o "protocolVersion" especificado.
     *
     * @param       string $protocolVersion
     *              O novo valor para "protocolVersion" na nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para "protocolVersion".
     */
    public function withProtocolVersion($protocolVersion)
    {
        $this->validateProtocolVersion($protocolVersion, true);

        $clone = $this->cloneThisInstance();
        $clone->protocolVersion = $protocolVersion;

        return $clone;
    }










    /**
     * Objeto que implementa "iHeaderCollection".
     *
     * @var         iHeaderCollection
     */
    protected $headers = null;
    /**
     * Retorna um array associativo onde cada chave é um header HTTP
     * usado na mensagem.
     * Valores múltiplos (separados por virgula) serão quebrados
     * em um novo array de valores.
     *
     * O formato do nome do header é mantido conforme ele foi definido.
     *
     * @return      array[][]
     */
    public function getHeaders() : array
    {
        return $this->headers->toArray(true);
    }





    /**
     * Verifica se um determinado header já existe.
     * Esta método é "case-insensitive".
     *
     * @param       string $name
     *              Nome do header alvo.
     *
     * @return      bool
     */
    public function hasHeader($name) : bool
    {
        return $this->headers->has($name);
    }
    /**
     * Retorna a coleção de valores que o header de nome indicado possui
     * no momento. Um array vazio será retornado caso o header não exista.
     * Esta método é "case-insensitive".
     *
     * @param       string $name
     *              Nome do header alvo.
     *
     * @return      array
     */
    public function getHeader($name) : array
    {
        return (($this->headers->has($name) === true) ? $this->headers->get($name) : []);
    }
    /**
     * Retorna uma string representando toda a coleção de valores determinados
     * para o header de nome indicado. Cada valor é separado por virgula.
     * Esta método é "case-insensitive".
     *
     * Uma string vazia será retornada caso o header não exista.
     *
     * @param       string $name
     *              Nome do header alvo.
     *
     * @return      string
     */
    public function getHeaderLine($name) : string
    {
        $str = "";

        $r = $this->getHeader($name);
        $str = implode(", ", $r);

        return $str;
    }





    /**
     * Este método DEVE manter o estado da instância atual e retornar
     * uma nova instância contendo o novo valor para o "header" especificado.
     *
     * Este método substitui integralmente o valor do "header" pelo novo valor
     * caso já exista um para a chave indicada..
     *
     *
     * @param       string $name
     *              Nome do header.
     *
     * @param       string|array $value
     *              Valor do header.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para o nome ou valor do header.
     */
    public function withHeader($name, $value)
    {
        if (is_string($name) === false || $name === "") {
            throw new \InvalidArgumentException("Invalid given \"name\" value. Must be a non empty string.");
        }

        $clone = $this->cloneThisInstance();

        $clone->headers->remove($name);
        $clone->headers->set($name, $value);

        return $clone;
    }
    /**
     * Este método DEVE manter o estado da instância atual e retornar
     * uma nova instância contendo a adição feita para o "header" especificado.
     *
     * Este método pode/deve adicionar o novo "header" na coleção existente
     * caso ele não exista e, se existir, incrementar seu valor atual com o
     * valor informado.
     *
     *
     * @param       string $name
     *              Nome do header.
     *
     * @param       string|array $value
     *              Valores a serem adicionados ao header.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para o nome ou valor do header.
     */
    public function withAddedHeader($name, $value)
    {
        if (is_string($name) === false || $name === "") {
            throw new \InvalidArgumentException("Invalid given \"name\" value. Must be a non empty string.");
        }

        $clone = $this->cloneThisInstance();
        $clone->headers->set($name, $value);

        return $clone;
    }
    /**
     * Este método DEVE manter o estado da instância atual e retornar
     * uma nova instância sem o "header" especificado.
     *
     * @param       string $name
     *              Nome do header.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para o nome do header.
     */
    public function withoutHeader($name)
    {
        if (is_string($name) === false || $name === "") {
            throw new \InvalidArgumentException("Invalid given \"name\" value. Must be a non empty string.");
        }

        $clone = $this->cloneThisInstance();
        $clone->headers->remove($name);

        return $clone;
    }










    /**
     * "Stream" que representa o corpo da mensagem.
     *
     * @var         iStream
     */
    protected $body = null;
    /**
     * Retorna o objeto "Stream" que forma o corpo da mensagem HTTP.
     * O objeto deve implementar a interface "iStream".
     *
     * @see         http://www.php-fig.org/psr/
     *
     * @return      iStream
     */
    public function getBody() : iStream
    {
        return $this->body;
    }
    /**
     * Este método DEVE manter o estado da instância atual e retornar
     * uma nova instância contendo o "body" especificado.
     *
     * @param       StreamInterface $body
     *              Objeto "StreamInterface".
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para o novo "body".
     */
    public function withBody(StreamInterface $body)
    {
        return $this->cloneThisInstance(null, $body);
    }




















    /**
     * Inicia um novo objeto que representa uma mensagem HTTP.
     *
     * @param       string $version
     *              Versão do protocolo HTTP
     *
     * @param       iHeaderCollection $headers
     *              Objeto que implementa "iHeaderCollection"
     *              cotendo os cabeçalhos da requisição.
     *
     * @param       iStream $body
     *              Objeto "Stream" representando o corpo da mensagem.
     *
     * @throws      \InvalidArgumentException
     */
    function __construct(
        string $version,
        iHeaderCollection $headers,
        iStream $body
    ) {
        $this->validateProtocolVersion($version, true);

        $this->protocolVersion = $version;
        $this->headers = $headers;
        $this->body = $body;
    }










    /**
     * Desabilita a função mágica "__set" para assegurar a imutabilidade
     * da instância conforme definido na interface "iUri".
     *
     * @codeCoverageIgnore
     *
     */
    public function __set($name, $value)
    {
        // Não produz efeito
    }
}
