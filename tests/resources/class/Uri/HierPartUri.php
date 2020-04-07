<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Tests\Concrete;

use AeonDigital\Http\Uri\Abstracts\aHierPartUri as aHierPartUri;








/**
 * Classe concreta do tipo "iHierPartUri".
 */
class HierPartUri extends aHierPartUri
{
    public static function fromString(string $uri)
    {
    }
    public function __toString()
    {
        return $this->scheme;
    }
    function __construct(
        string $scheme = "",
        string $user = "",
        string $password = null,
        string $host = "",
        ? int $port = null,
        string $path = ""
    ) {
        parent::__construct($scheme, $user, $password, $host, $port, $path);
    }
}
