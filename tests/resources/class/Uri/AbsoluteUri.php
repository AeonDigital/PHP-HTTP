<?php
declare (strict_types=1);

namespace AeonDigital\Http\Uri\Tests\Concrete;

use AeonDigital\Http\Uri\Abstracts\aAbsoluteUri as aAbsoluteUri;








/**
 * Classe concreta do tipo "iAbsoluteUri".
 */
class AbsoluteUri extends aAbsoluteUri
{
    function __construct(
        string $scheme = "",
        string $user = "",
        ?string $password = null,
        string $host = "",
        ?int $port = null,
        string $path = "",
        string $query = "",
        string $fragment = ""
    ) {
        parent::__construct($scheme, $user, $password, $host, $port, $path, $query, $fragment);
    }
}
