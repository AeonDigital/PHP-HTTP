<?php

declare(strict_types=1);

namespace AeonDigital\Http\Data;

use AeonDigital\Interfaces\Http\Data\iCookie as iCookie;
use AeonDigital\BObject as BObject;






/**
 * Representa um cookie.
 *
 * @see http://www.ietf.org/rfc/rfc6265.txt
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Cookie extends BObject implements iCookie
{
    use \AeonDigital\Traits\MainCheckArgumentException;



    /**
     * Nome do cookie
     *
     * @var string
     */
    protected string $name = "";
    /**
     * Define o nome do cookie.
     *
     * @param string $name
     * Nome do cookie.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     * Caso o valor indicado seja inválido.
     */
    public function setName(string $name): void
    {
        $this->mainCheckForInvalidArgumentException(
            "name",
            $name,
            [
                [
                    "validate"          => "is string matches pattern",
                    "patternPregMatch"  => "/^([a-zA-Z0-9_])+$/",
                    "errorShowPattern"  => "a-zA-Z0-9_"
                ]
            ]
        );
        $this->name = $name;
    }
    /**
     * Retorna o nome identificador do cookie.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }





    /**
     * Valor do cookie.
     *
     * @var string
     */
    protected string $value = "";
    /**
     * Define o valor do cookie.
     * O valor será armazenado em ``percent-encode``.
     *
     * @param string $value
     * Valor do cookie.
     *
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->value = $this->percentEncode($value);
    }
    /**
     * Retorna o valor do cookie.
     * O valor será retornado usando ``percent-encode``.
     *
     * @param bool $urldecoded
     * Indica se o valor retornado deve ser convertido para o formato **natural**,
     * sem ``percent-encode``.
     *
     * @return string
     */
    public function getValue(bool $urldecoded = true): string
    {
        return (($urldecoded === true) ? \rawurldecode($this->value) : $this->value);
    }





    /**
     * Objeto "DateTime" do momento em que o cookie deve
     * ser eliminado.
     *
     * @var ?\DateTime
     */
    protected ?\DateTime $expires = null;
    /**
     * Define o ``Expires`` do cookie.
     *
     * O valor ``null`` irá remover esta propriedade do cookie.
     *
     * @param ?\DateTime $expires
     * Data de expiração.
     *
     * @return void
     */
    public function setExpires(?\DateTime $expires): void
    {
        $this->expires = $expires;
    }
    /**
     * Retorna o atual valor de ``Expires`` definido para este cookie em formato \DateTime.
     *
     * O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
     *
     * @return ?\DateTime
     */
    public function getExpires(): ?\DateTime
    {
        return $this->expires;
    }
    /**
     * Retorna o atual valor de ``Expires`` definido para este cookie.
     * O valor deve ser devolvido usando o modelo:
     *
     * ```
     *  strDay(3 char), intDay strMonth(3 char) intYear intHour:intMinute:intSec UTC
     * ```
     *
     * O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
     *
     * @return ?string
     */
    public function getStrExpires(): ?string
    {
        return (($this->expires === null) ? null : $this->expires->format("D, d M Y H:i:s") . " UTC");
    }





    /**
     * Domínio do cookie.
     *
     * @var ?string
     */
    protected ?string $domain = null;
    /**
     * Define o ``Domain`` do cookie.
     *
     * O valor ``null`` irá remover esta propriedade do cookie.
     *
     * @param ?string $domain
     * Domain.
     *
     * @return void
     */
    public function setDomain(?string $domain): void
    {
        $this->domain = (($domain === null) ? null : \strtolower($domain));
    }
    /**
     * Retorna o ``Domain`` definido para este cookie.
     * O velor deve ser devolvido em seu formato ``lowerCase``.
     *
     * O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
     *
     * @return ?string
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }





    /**
     * Path do cookie.
     *
     * @var string
     */
    protected string $path = "/";
    /**
     * Define o ``Path`` do cookie.
     *
     * O valor ``null`` irá remover esta propriedade do cookie.
     *
     * @param ?string $path
     * Path.
     *
     * @return void
     */
    public function setPath(?string $path): void
    {
        if (\strpos($path, "/") !== 0) {
            $path = "/" . $path;
        }
        $this->path = $path;
    }
    /**
     * Retorna o ``Path`` definido para este cookie.
     *
     * O valor ``/`` será retornado caso nenhum valor esteja definido para esta propriedade.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }





    /**
     * Atributo "secure".
     *
     * @var bool
     */
    protected bool $secure = false;
    /**
     * Define se o cookie é do tipo ``Secure``.
     *
     * Quando ``true`` significa que o cookie só deve trafegar em canais seguros (tipicamente
     * ``Http`` sobre uma camada TSL).
     *
     * O valor ``null`` irá remover esta propriedade do cookie.
     *
     * @param bool $secure
     * Secure.
     *
     * @return void
     */
    public function setSecure(bool $secure): void
    {
        $this->secure = $secure;
    }
    /**
     * Indica se a diretiva ``Secure`` deve ser aplicada.
     *
     * Quando ``true`` significa que o cookie só deve trafegar em canais seguros (tipicamente
     * ``Http`` sobre uma camada TSL).
     *
     * @return bool
     */
    public function getSecure(): bool
    {
        return $this->secure;
    }





    /**
     * Atributo "httpOnly".
     *
     * @var bool
     */
    protected bool $httpOnly = false;
    /**
     * Define se o cookie é do tipo ``HttpOnly``.
     *
     * Quando ``true`` significa que o cookie só deve trafegar em via ``Http``.
     *
     * O valor ``null`` irá remover esta propriedade do cookie.
     *
     * @param bool $httpOnly
     * HttpOnly.
     *
     * @return void
     */
    public function setHttpOnly(bool $httpOnly): void
    {
        $this->httpOnly = $httpOnly;
    }
    /**
     * Indica se a diretiva ``HttpOnly`` deve ser aplicada.
     *
     * Quando ``true`` significa que o cookie só deve trafegar em via ``Http``.
     *
     * @return bool
     */
    public function getHttpOnly(): bool
    {
        return $this->httpOnly;
    }










    /**
     * Inicia um novo objeto ``Cookie``.
     *
     * @param string $name
     * Nome do cookie.
     *
     * @param string $value
     * Valor do cookie.
     *
     * @param ?\DateTime $expires
     * Data de expiração do cookie.
     *
     * @param ?string $domain
     * Domínio.
     *
     * @param ?string $path
     * Path.
     *
     * @param bool $secure
     * Secure.
     *
     * @param bool $httpOnly
     * HttpOnly.
     *
     *
     * @throws \InvalidArgumentException
     * Caso algum dos valores iniciais a serem definidos não
     * seja aceito.
     */
    function __construct(
        string $name,
        string $value = "",
        ?\DateTime $expires = null,
        ?string $domain = null,
        ?string $path = "/",
        bool $secure = false,
        bool $httpOnly = false
    ) {
        $this->setName($name);
        $this->setValue($value);
        $this->setExpires($expires);
        $this->setDomain($domain);
        $this->setPath($path);
        $this->setSecure($secure);
        $this->setHttpOnly($httpOnly);
    }










    /**
     * Aplica ``percent-encoding`` aos caracteres ``unsafe``.
     *
     * @param string $value
     * Valor que será encodado.
     *
     * @see https://tools.ietf.org/html/rfc3986#section-2.1
     * @see http://www.faqs.org/rfcs/rfc3986.html
     *
     * @return string
     */
    protected function percentEncode(string $value): string
    {
        // Se o valor já está encodado... remove encoding
        $value = \str_replace("+", "%20", $value);
        while ((\strpos($value, "%") !== false && \rawurlencode(\rawurldecode($value)) === $value)) {
            $value = \rawurldecode($value);
        }

        return \rawurlencode($value);
    }










    /**
     * Devolve uma string com o valor completo do Cookie.
     *
     * ```
     *  name=value; [Expires=string;] [Domain=string;] [Path=string;] [Secure;] [HttpOnly;]
     * ```
     *
     * @param bool $urldecoded
     * Indica se o valor retornado deve ser convertido para o formato **natural**,
     * sem ``percent-encode``.
     *
     * @return string
     */
    public function toString(bool $urldecoded = true): string
    {
        $str = $this->name . "=" . $this->getValue($urldecoded) . ";";

        if ($this->expires !== null) {
            $str .= " Expires=" . $this->getStrExpires() . ";";
        }
        if ($this->domain !== null) {
            $str .= " Domain=" . $this->domain . ";";
        }
        if ($this->path !== null) {
            $str .= " Path=" . $this->path . ";";
        }
        if ($this->secure !== null) {
            $str .= " Secure;";
        }
        if ($this->httpOnly !== null) {
            $str .= " HttpOnly;";
        }

        return $str;
    }





    /**
     * Cria o cookie e envia-o para o ``UA``.
     * O retorno ``true`` apenas indica que a operação foi concluída mas não que o ``UA``
     * aceitou o Cookie.
     *
     * @return bool
     */
    public function defineCookie(): bool
    {
        return \setcookie(
            $this->name,
            $this->value,
            [
                "expires"   => (($this->expires === null) ? null : $this->expires->getTimestamp()),
                "path"      => $this->path,
                "domain"    => $this->domain,
                "secure"    => $this->secure,
                "httponly"  => $this->httpOnly,
                "sameSite"  => (($this->secure === true) ? "Strict" : "Lax")
            ]
        );
    }





    /**
     * Remove o cookie atual.
     *
     * O retorno ``true`` apenas indica que a operação foi concluída mas não que o ``UA``
     * aceitou o Cookie.
     *
     * @return bool
     */
    public function removeCookie(): bool
    {
        return \setcookie(
            $this->name,
            false,
            -1,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httpOnly
        );
    }









    /**
     * Converte a string passada em um objeto Cookie.
     *
     * @param string $str
     * String do objeto Cookie.
     *
     * @return Cookie
     *
     * @throws \InvalidArgumentException
     * Se a conversão não for possível.
     */
    public static function fromString(string $str): Cookie
    {
        $err = false;
        $name = "";
        $value = "";
        $expires = null;
        $domain = null;
        $path = "/";
        $secure = false;
        $httpOnly = false;


        if ($str === "") {
            $err = "The string is not a valid representation of a cookie.";
        }


        if ($err === false) {
            $parts = \array_map("trim", \explode(";", $str));

            $nameValue = \explode("=", $parts[0]);

            $name = $nameValue[0];
            $value = ((\count($nameValue) === 2) ? $nameValue[1] : "");

            if (\count($parts) > 1) {
                \array_shift($parts);

                foreach ($parts as $p) {
                    $keyPair = \array_map("trim", \explode("=", $p));
                    if (\count($keyPair) === 1) {
                        $keyPair[] = null;
                    }

                    $val = $keyPair[1];

                    switch (\strtolower($keyPair[0])) {
                        case "expires":
                            if ($val !== null) {
                                if (\is_numeric($val) === true) {
                                    $expires = new \DateTime();
                                    $expires->setTimestamp((int)$val);
                                } else {
                                    if (
                                        \strpos(\strtolower($val), " utc") !== false ||
                                        \strpos(\strtolower($val), " gmt") !== false
                                    ) {
                                        $val = \substr($val, 0, \strlen($val) - 4);
                                    }
                                    $expires = \DateTime::createFromFormat("D, d M Y H:i:s", $val);
                                }
                            }
                            break;

                        case "domain":
                            $domain = $val;
                            break;

                        case "path":
                            $path = $val;
                            break;

                        case "secure":
                            $secure = true;
                            break;

                        case "httponly":
                            $httpOnly = true;
                            break;
                    }
                }
            }
        }


        if ($err === false) {
            return new Cookie($name, $value, $expires, $domain, $path, $secure, $httpOnly);
        } else {
            throw new \InvalidArgumentException($err);
        }
    }
    /**
     * Converte uma string de dados brutos em um array de cookies correspondendo às informações
     * existentes para cada qual.
     *
     * Retorna um array associativo onde:
     *
     * ```
     *  ["cookieName" => Cookie ]
     * ```
     *
     *
     * @param string $str
     * String dos objetos Cookie.
     *
     * @return array
     *
     *
     * @throws \InvalidArgumentException
     * Se a conversão não for possível.
     */
    public static function fromRawCookieHeader(string $str): array
    {
        $coll = [];

        $parts = \array_map("trim", \explode(";", $str));
        $cookies = [];

        foreach ($parts as $part) {
            if ($part !== "") {
                $s = \explode("=", $part);

                switch (\strtolower($s[0])) {
                    case "expires":
                    case "domain":
                    case "path":
                    case "secure":
                    case "httponly":
                        $i = \count($cookies) - 1;
                        $cookies[$i][] = $part;
                        break;

                    default:
                        $cookies[] = [$part];
                        break;
                }
            }
        }


        foreach ($cookies as $cookie) {
            $str = \implode(";", $cookie) . ";";
            $nC = self::fromString($str);
            $coll[$nC->getName()] = $nC;
        }

        return $coll;
    }
}
