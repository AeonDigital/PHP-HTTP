<?php
declare (strict_types = 1);

namespace AeonDigital\Http\Data\Abstracts;

use AeonDigital\Collection\Collection as Collection;







/**
 * Classe abstrata que serve de base para as demais
 * collections de dados Http.
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
abstract class aHttpDataCollection extends Collection
{





    /**
     * Utiliza as informações da string indicada para iniciar uma nova
     * coleção de dados.
     *
     * @param       string $str
     *              String que será convertida em uma nova coleção.
     *
     * @return      static
     *
     * @throws      \InvalidArgumentException
     *              Caso a string passada seja inválida para construção de
     *              uma nova coleção.
     */
    abstract public static function fromString(string $str);
}
