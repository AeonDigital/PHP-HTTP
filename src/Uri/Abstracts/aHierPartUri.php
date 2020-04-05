<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Abstracts;

use AeonDigital\Interfaces\Http\Uri\iHierPartUri as iHierPartUri;
use AeonDigital\Http\Uri\Abstracts\aBasicUri as aBasicUri;







/**
 * Implementa a interface ``iHierPartUri``.
 *
 * @package     AeonDigital\Http\Uri
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
abstract class aHierPartUri extends aBasicUri implements iHierPartUri
{





    /**
     * Array associativo contendo cada tipo de ``scheme`` que deve ser aceito pela classe
     * concreta que herda esta abstração em relação ao valor padrão para o componente
     * ``port``.
     *
     * ```
     *  [
     *      "http"     => 80
     *      "https"    => 433
     *      "ftp"      => 21
     *  ]
     * ```
     *
     * A responsabilidade pelo preenchimento dos dados desta propriedade fica para as classes
     * concretas que herdarão desta.
     *
     * @var         array
     */
    protected $defaultSchemePort = [
        ""              => null,
        "http"          => 80,
        "https"         => 433,
        "ftp"           => 21,
        "ssh"           => 22,
        "urn"           => 80,
        "view-source"   => 80,
        "ws"            => 80,
        "wss"           => 433,
        "file"          => 80
    ];










    /**
     * Componente ``user`` da ``URI``.
     *
     * @var         string
     */
    protected $user = "";
    /**
     * Retorna o componente ``user`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O valor será retornado usando ``percent-encoding``.
     *
     * @return      string
     */
    public function getUser() : string
    {
        return $this->user;
    }





    /**
     * Verifica se o ``user`` indicado é válido.
     *
     * @param       string $user
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``user`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateUser($user, bool $throw = false) : bool
    {
        $r = is_string($user);
        if (is_string($user) === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"user\" value. Must be an string.");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``user`` indicado.
     *
     * @param       string $user
     *              Valor de ``user``.
     *
     * @return      string
     */
    protected function normalizeUser(string $user) : string
    {
        return $this->percentEncode($user);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``user`` especificado.
     *
     * @param       ?string $user
     *              O novo valor para ``user`` para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``user``.
     */
    public function withUser($user)
    {
        $this->validateUser($user, true);

        $clone = clone $this;
        $clone->user = $this->normalizeUser($user);
        return $clone;
    }










    /**
     * Componente ``password`` da ``URI``.
     * Uma ``password`` pode ser uma string vazia, portanto o valor ``null`` indica quando ela
     * não está setada.
     *
     * @var         ?string
     */
    protected $password = null;
    /**
     * Retorna o componente ``password`` da ``URI``.
     * Uma ``password`` pode ser uma string vazia, portanto o valor ``null`` indica quando ela
     * não está setada.
     * O valor será retornado usando ``percent-encoding``.
     *
     * @return      ?string
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }





    /**
     * Verifica se o ``password`` indicado é válido.
     *
     * @param       string $password
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``password`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validatePassword($password, bool $throw = false) : bool
    {
        // Aceita apenas NULL ou valores que são String
        $r = ($password === null || is_string($password) === true);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"password\" value. Must be an string or \"null\".");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``password`` indicado.
     *
     * @param       ?string $password
     *              Valor de ``password``.
     *
     * @return      ?string
     */
    protected function normalizePassword(?string $password) : ?string
    {
        if ($password === null) {
            return null;
        }
        return $this->percentEncode($password);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``password`` especificado.
     *
     * @param       ?string $password
     *              O novo valor para ``password`` para a nova instância.
     *              Se ``null`` for passado, o valor da ``password`` será removido.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``password``.
     */
    public function withPassword($password = null)
    {
        $this->validatePassword($password, true);

        $clone = clone $this;
        $clone->password = $this->normalizePassword($password);
        return $clone;
    }










    /**
     * Componente ``host`` da ``URI``.
     *
     * @var         string
     */
    protected $host = "";
    /**
     * Retorna o componente ``host`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     *
     * @return      string
     */
    public function getHost() : string
    {
        return $this->host;
    }





    /**
     * Verifica se o ``host`` indicado é válido.
     *
     * @param       string $host
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``host`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateHost($host, bool $throw = false) : bool
    {
        $r = is_string($host);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"host\" value. Must be an string.");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``host`` indicado.
     *
     * @param       string $host
     *              Valor de ``host``.
     *
     * @return      string
     */
    protected function normalizeHost(string $host) : string
    {
        return strtolower($host);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``host`` especificado.
     *
     * @param       string $host
     *              O novo valor para ``host`` para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``host``.
     */
    public function withHost($host)
    {
        $this->validateHost($host, true);

        $clone = clone $this;
        $clone->host = $this->normalizeHost($host);
        return $clone;
    }










    /**
     * Componente ``port`` da ``URI``.
     *
     * @var         ?int
     */
    protected $port = null;
    /**
     * Retorna o componente ``port`` da ``URI`` ou ``null`` caso a porta definida seja a padrão
     * para o ``scheme`` que está sendo usado.
     *
     * @return      ?int
     */
    public function getPort() : ?int
    {
        return (($this->port === $this->getDefaultPort()) ? null : $this->port);
    }





    /**
     * Retorna a porta padrão para o ``scheme`` definido para este ``URI``.
     * Se o ``scheme`` não possui uma porta padrão deverá ser retornado ``null``.
     *
     * @return      ?int
     */
    public function getDefaultPort() : ?int
    {
        return $this->defaultSchemePort[$this->getScheme()];
    }
    /**
     * Verifica se a ``port`` indicada é válida.
     *
     * @param       ?int $port
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso a ``port`` definida seja inválida e ``$throw`` seja ``true``.
     */
    protected function validatePort($port, bool $throw = false) : bool
    {
        $r = ($port === null);
        if ($r === false && is_int($port) === true) {
            $r = ($port >= 1 && $port <= 65535);
        }

        if ($throw === true && $r === false) {
            throw new \InvalidArgumentException("Invalid given \"port\" value, it must be an int between 1 and 65535 [ \"" . $port . "\" ].");
        }
        return $r;
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``port`` especificado.
     *
     * @param       ?int $port
     *              O novo valor para ``port`` para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``port``.
     */
    public function withPort($port)
    {
        $this->validatePort($port, true);

        $clone = clone $this;
        $clone->port = $port;
        return $clone;
    }










    /**
     * Componente ``user information`` da ``URI``.
     * Se este componente não estiver presente na ``URI`` será retornado ``''``.
     * Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
     * este formato.
     *
     * A sintaxe padrão deste componente é:
     *
     * ```
     *  [username[:password]]
     * ```
     *
     * @return      string
     */
    public function getUserInfo() : string
    {
        return ($this->user . ($this->password === null ? "" : ":" . $this->password));
    }





    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``user information`` especificado.
     *
     * @param       string $user
     *              O novo valor para ``user`` na nova instância.
     *
     * @param       string $password
     *              O novo valor para ``password`` na nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para algum argumento.
     */
    public function withUserInfo($user, $password = null)
    {
        $this->validateUser($user, true);
        $this->validatePassword($password, true);

        $clone = clone $this;
        $clone->user = $this->normalizeUser($user);
        $clone->password = $this->normalizePassword($password);
        return $clone;
    }










    /**
     * Componente ``authority`` da ``URI``.
     * Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
     * este formato.
     *
     * A sintaxe padrão deste componente é:
     *
     * ```
     *  [[user-info@]host[:port]]
     * ```
     *
     * O componente ``port`` deve ser omitido quando esta não estiver definida, ou, se for uma
     * das portas padrão para o ``scheme`` atualmente em uso.
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-3.2
     *
     * @return      string
     */
    public function getAuthority() : string
    {
        $userInfo = $this->getUserInfo();
        $host = $this->getHost();
        $port = $this->getPort();

        return (($userInfo === "" ? "" : $userInfo . "@") . $host . ($port === null ? "" : ":" . $port));
    }





    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo a parte "autority" especificado.
     *
     * @param       string $user
     *              O novo valor para ``user`` na nova instância.
     *
     * @param       ?string $password
     *              O novo valor para ``password`` para a nova instância.
     *              Se ``null`` for passado, o valor da ``password`` será removido.
     *
     * @param       string $host
     *              O novo valor para ``host`` na nova instância.
     *
     * @param       ?int $port
     *              O novo valor para ``port`` na nova instância.
     *              Use ``null`` para ignorar usar o valor padrão para o ``scheme``.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para algum argumento.
     */
    public function withAuthority($user = "", $password = null, $host = "", $port = null)
    {
        $this->validateUser($user, true);
        $this->validatePassword($password, true);
        $this->validateHost($host, true);
        $this->validatePort($port, true);

        $clone = clone $this;
        $clone->user = $this->normalizeUser($user);
        $clone->password = $this->normalizePassword($password);
        $clone->host = $this->normalizeHost($host);
        $clone->port = $port;
        return $clone;
    }










    /**
     * Componente ``path`` da ``URI``.
     *
     * @var         string
     */
    protected $path = "";
    /**
     * Retorna o componente ``path`` da ``URI`` ou ``''`` caso ele não esteja especificado.
     * O valor será retornado usando ``percent-encoding``.
     *
     * @return      string
     */
    public function getPath() : string
    {
        return $this->path;
    }





    /**
     * Verifica se o ``path`` indicado é válido.
     *
     * @param       string $path
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma exception
     *              em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``path`` definido seja inválido e $throw seja ``true``.
     */
    protected function validatePath($path, bool $throw = false) : bool
    {
        $r = is_string($path);
        if ($r === false && $throw === true) {
            throw new \InvalidArgumentException("Invalid given \"path\" value. Must be an string.");
        }
        return $r;
    }
    /**
     * Normaliza o valor do ``path`` indicado.
     *
     * @param       string $path
     *              Valor de ``path``.
     *
     * @return      string
     */
    protected function normalizePath(string $path) : string
    {
        return implode("/", array_map("rawurlencode", explode("/", $path)));
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``path`` especificado.
     *
     * @param       string $path
     *              O novo valor para ``path`` para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``path``.
     */
    public function withPath($path)
    {
        $this->validatePath($path, true);

        $clone = clone $this;
        $clone->path = $this->normalizePath($path);
        return $clone;
    }










    /**
     * Inicia uma instância ``authority`` de uma ``URI``.
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
     * @throws      \InvalidArgumentException
     *              Caso algum dos parametros passados seja inválido.
     */
    function __construct(
        string $scheme = "",
        string $user = "",
        ?string $password = null,
        string $host = "",
        ?int $port = null,
        string $path = ""
    ) {
        parent::__construct($scheme, array_keys($this->defaultSchemePort));

        $this->validateUser($user, true);
        $this->validatePassword($password, true);
        $this->validateHost($host, true);
        $this->validatePort($port, true);
        $this->validatePath($path, true);

        $this->user = $this->normalizeUser($user);
        $this->password = $this->normalizePassword($password);
        $this->host = $this->normalizeHost($host);
        $this->port = $port;
        $this->path = $this->normalizePath($path);
    }










    /**
     * Retorna uma string que representa a parte básica da ``URI`` representada pela instância.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ]
     * ```
     *
     * @return      string
     */
    public function getBase() : string
    {
        $scheme = $this->getScheme();
        $authority = $this->getAuthority();

        $baseUri = (($scheme === "") ? "" : $scheme . ":") . (($authority === "") ? "" : "//" . $authority);

        return $baseUri;
    }



    /**
     * Retorna uma string que representa toda a parte hierarquica da ``URI`` representada pela
     * instância.
     *
     * O resultado será uma string com o seguinte formato:
     *
     * ```
     *  [ scheme ":" ][ "//" authority ][ "/" path ]
     * ```
     *
     * @return      string
     */
    public function getBasePath() : string
    {
        $baseUri = $this->getBase();
        $path = ltrim($this->getPath(), "/");

        $absoluteUri = $baseUri . (($path === "") ? "" : "/" . $path);

        return $absoluteUri;
    }
}
