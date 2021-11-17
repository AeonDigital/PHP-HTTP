<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Tests\Concrete;

use AeonDigital\Http\Uri\Abstracts\aBasicUri as aBasicUri;








/**
 * Classe concreta do tipo "iBasicUri".
 */
class BasicUri extends aBasicUri
{
    public static function fromString(string $uri)
    {
    }
    public function __toString()
    {
        return $this->scheme;
    }
    function __construct(string $scheme = "", array $acceptSchemes = [])
    {
        parent::__construct($scheme, $acceptSchemes);
    }
}
