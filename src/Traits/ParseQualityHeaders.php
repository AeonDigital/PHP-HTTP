<?php

declare(strict_types=1);

namespace AeonDigital\Http\Traits;









/**
 * Fornece métodos relacionados a verificação qualitativa dos ``headers`` que utilizam indicativos
 * de qualificação.
 *
 * @package     AeonDigital\Http\Traits
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
trait ParseQualityHeaders
{





    /**
     * Trata os valores de ``headers`` marcados com parametros **quality** que identificam a
     * preferência de algum tipo de conteúdo ou comportamento sobre outro.
     *
     * Retorna um ``array`` ordenado dos dados encontrados em ordem de preferência.
     * Valores em igual nível de preferência serão retornados alfabeticamente.
     *
     * ```php
     *      $headers = [
     *          "text/html",
     *          "application/xhtml+xml",
     *          "application/xml;q=0.9",
     *          "* /*;q=0.8"
     *      ];
     *
     *      $return = [
     *          // string   "value"     Valor real.
     *          // float    "quality"   Nível da "qualidade" atribuido.
     *          ["value" => "text/html", "quality" => 1],
     *          ["value" => "application/xhtml+xml", "quality" => 1],
     *          ["value" => "application/xml", "quality" => 0.9],
     *          ["value" => "* /*", "quality" => 0.8]
     *      ];
     * ```
     *
     * @param ?array $headers
     * Valores do header em formato de ``array``.
     *
     * @return ?array
     * O objeto de retorno é um **array de arrays associativos** conforme
     * exemplificado acima.
     */
    public function parseArrayOfQualityHeaders(?array $headers): ?array
    {
        $r = null;

        if ($headers !== null) {
            $indexQuality = [];
            $qualitIncreasse = 100;

            foreach ($headers as $rawPart) {
                $rawPart = \str_replace("; q=", ";q=", $rawPart);
                list($value, $quality) = \array_merge(\explode(";q=", $rawPart), [1]);

                $value = \trim($value);
                $quality = \trim((string)$quality);

                $indexQuality[] = (float)$quality + $qualitIncreasse;
                $r[] = ["value" => $value, "quality" => (float)$quality];

                $qualitIncreasse--;
            }

            \array_multisort($indexQuality, SORT_DESC, $r);
        }

        return $r;
    }





    /**
     * Trata os valores brutos de ``headers`` marcados com parametros **quality** que identificam a
     * preferência de algum tipo de conteúdo ou comportamento sobre outro.
     *
     * Retorna um ``array`` ordenado dos dados encontrados em ordem de preferência.
     * Valores em igual nível de preferência serão retornados alfabeticamente.
     *
     * ```php
     *      $headers = "text/html,application/xhtml+xml,application/xml;q=0.9,* /*;q=0.8";
     *
     *      $return = [
     *          // string   "value"     Valor real.
     *          // float    "quality"   Nível da "qualidade" atribuido.
     *          ["value" => "text/html", "quality" => 1],
     *          ["value" => "application/xhtml+xml", "quality" => 1],
     *          ["value" => "application/xml", "quality" => 0.9],
     *          ["value" => "* /*", "quality" => 0.8]
     *      ];
     * ```
     *
     * @param ?string $headers
     * Versão bruta do ``header``.
     *
     * @return ?array
     * O objeto de retorno é um **array de arrays associativos** conforme
     * exemplificado acima.
     */
    public function parseRawLineOfQualityHeaders(?string $headers): ?array
    {
        $r = null;

        if ($headers !== null && $headers !== "") {
            // Separa os valores do header em seus componentes fundamentais
            $splitedHeader = \explode(",", $headers);
            $r = $this->parseArrayOfQualityHeaders($splitedHeader);
        }

        return $r;
    }





    /**
     * Trata o valor bruto de um header ``AcceptLanguage`` e retorna um ``array``.
     *
     * Retornará um ``array`` associativo contendo 2 chaves, **locales** e **languages** sendo
     * cada uma um ``array`` trazendo aquela informação em ordem de prioridade.
     *
     * Os valores serão retornados todos em ``lowercase``.
     *
     * ```php
     *      $headers = [
     *          "pt-BR",
     *          "pt;q=0.8",
     *          "en-US;q=0.5",
     *          "en;q=0.3"
     *      ];
     *
     *      $return = [
     *          // string[]   "locales"       Coleção de locales aceitos.
     *          // string[]   "languages"     Coleção de linguagens aceitas.
     *          "locales" => ["pt-br", "en-us"],
     *          "languages" => ["pt", "en"],
     *      ];
     * ```
     *
     * @param ?array $headers
     * Valores do ``header`` em formato de ``array``.
     *
     * @return ?array
     */
    public function parseArrayOfHeaderAcceptLanguage(?array $headers): ?array
    {
        $r = null;

        if ($headers !== null && \count($headers) > 0) {
            $headers = $this->parseRawLineOfQualityHeaders(\implode(",", $headers));

            $locales = [];
            $languages = [];

            $lang = [];
            foreach ($headers as $k => $val) {
                $uVal = \trim($val["value"]);

                if (\strlen($uVal) === 5) {
                    $locales[] = \strtolower($uVal);
                    $lang[] = \strtolower(\substr($uVal, 0, 2));
                } elseif (\strlen($uVal) === 2) {
                    $languages[] = \strtolower($uVal);
                }
            }

            $languages = \array_merge($languages, $lang);
            $languages = \array_unique($languages);

            $r = [
                "locales" => $locales,
                "languages" => $languages
            ];
        }

        return $r;
    }





    /**
     * Trata o valor bruto de um ``header AcceptLanguage`` e retorna um ``array``.
     *
     * Retornará um ``Array Associativo`` contendo 2 chaves, **locales** e **languages** sendo
     * cada uma um ``array`` trazendo aquela informação em ordem de prioridade.
     *
     * Os valores serão retornados todos em ``lowercase``.
     *
     * ```php
     *      $headers = "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3";
     *
     *      $return = [
     *          // string[]   "locales"       Coleção de locales aceitos.
     *          // string[]   "languages"     Coleção de linguagens aceitas.
     *          "locales" => ["pt-br", "en-us"],
     *          "languages" => ["pt", "en"],
     *      ];
     * ```
     *
     * @param ?string $headers
     * Versão bruta do ``header``.
     *
     * @return ?array
     */
    public function parseRawLineOfHeaderAcceptLanguage(?string $headers): ?array
    {
        $r = null;

        if ($headers !== null && $headers !== "") {
            return $this->parseArrayOfHeaderAcceptLanguage(\array_map("trim", \explode(",", $headers)));
        }

        return $r;
    }
}
