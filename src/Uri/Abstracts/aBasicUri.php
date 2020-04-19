<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Abstracts;

use AeonDigital\Interfaces\Http\Uri\iBasicUri as iBasicUri;
use AeonDigital\BObject as BObject;







/**
 * Implementa a interface ``iBasicUri``.
 *
 * @package     AeonDigital\Http\Uri
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
abstract class aBasicUri extends BObject implements iBasicUri
{
    use \AeonDigital\Traits\MainCheckArgumentException;




    /**
     * Array unidimensional contendo cada tipo de ``scheme`` que deve ser aceito pela classe
     * concreta que herda esta abstração.
     *
     * Nas classes concretas, ou herdeiras desta, este array deve ser preenchido com uma coleção
     * de nomes de ``schemes`` que aquelas instâncias poderão representar.
     *
     * Os valores definidos aqui devem estar em formato ``lowercase``.
     *
     * @var         array
     */
    protected array $acceptSchemes = [];










    /**
     * Componente ``scheme`` da ``URI`` (sempre em lowercase).
     * Nomes válidos devem seguir o formato:
     *
     * ```
     *  scheme = ALPHA * ( ALPHA / DIGIT / "+" / "-" / "." )
     * ```
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-3.1
     *
     * @var         string
     */
    protected string $scheme = "";
    /**
     * Retorna o nome do ``scheme`` que o ``URI`` da classe está usando.
     *
     * @return      string
     */
    public function getScheme() : string
    {
        return $this->scheme;
    }





    /**
     * Verifica se o ``scheme`` indicado é válido.
     *
     * @param       string $scheme
     *              Valor que será testado.
     *
     * @param       bool $throw
     *              Quando ``true`` irá lançar uma ``exception`` em caso de falha.
     *
     * @return      bool
     *
     * @throws      \InvalidArgumentException
     *              Caso o ``scheme`` definido seja inválido e ``$throw`` seja ``true``.
     */
    protected function validateScheme($scheme, bool $throw = false) : bool
    {
        $this->mainCheckForInvalidArgumentException(
            "scheme", $scheme,
            [
                [
                    "validate" => "is string"
                ],
                [
                    "validate" => "is allowed value",
                    "allowedValues" => $this->acceptSchemes,
                    "caseInsensitive" => true
                ]
            ],
            $throw
        );
        return $this->getLastArgumentValidateResult();
    }
    /**
     * Normaliza o valor do ``scheme`` indicado.
     *
     * @param       string $scheme
     *              Valor de ``scheme``.
     *
     * @return      string
     */
    protected function normalizeScheme(string $scheme) : string
    {
        return \strtolower($scheme);
    }
    /**
     * Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
     * contendo o ``scheme`` especificado.
     *
     * @param       string $scheme
     *              O novo valor para ``scheme`` para a nova instância.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso seja definido um valor inválido para ``scheme``.
     */
    public function withScheme($scheme)
    {
        $this->validateScheme($scheme, true);

        $clone = clone $this;
        $clone->scheme = $this->normalizeScheme($scheme);
        return $clone;
    }










    /**
     * Aplica ``percent-encoding`` aos caracteres ``unsafe``.
     *
     * @param       string $value
     *              Valor que será encodado.
     *
     * @see         https://tools.ietf.org/html/rfc3986#section-2.1
     * @see         http://www.faqs.org/rfcs/rfc3986.html
     *
     * @return      string
     */
    protected function percentEncode(string $value) : string
    {
        // Se o valor já está encodado... remove encoding
        $value = \str_replace("+", "%20", $value);
        while ((\strpos($value, "%") !== false && \rawurlencode(\rawurldecode($value)) === $value)) {
            $value = \rawurldecode($value);
        }

        return \rawurlencode($value);
    }










    /**
     * Inicia uma instância básica de uma ``URI``.
     *
     * @param       string $scheme
     *              Define o ``scheme`` usado pelo ``URI``.
     *
     * @param       array $acceptSchemes
     *              Coleção de ``schemes`` permitidos para a serem definidos por uma classe
     *              concreta.
     *
     * @throws      \InvalidArgumentException
     *              Caso algum dos parametros passados seja inválido.
     */
    function __construct(
        string $scheme = "",
        array $acceptSchemes = []
    ) {
        $this->acceptSchemes = $acceptSchemes;

        $this->validateScheme($scheme, true);
        $this->scheme = $this->normalizeScheme($scheme);
    }










    /**
     * Desabilita a função mágica ``__set`` para assegurar a imutabilidade da instância conforme
     * definido na interface ``iUri``.
     *
     * @codeCoverageIgnore
     */
    public function __set($name, $value)
    {
        // Não produz efeito
    }
}
