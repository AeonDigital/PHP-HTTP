<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Traits\HTTPRawStatusCode as HTTPRawStatusCode;

require_once __DIR__ . "/../../phpunit.php";







class HTTPRawStatusCodeTest extends TestCase
{



    public function test_property_rawStatusCode()
    {
        $keysAndValues = [
            0   => null,
            100 => "Continue",
            203 => "Non-Authoritative Information",
            407 => "Proxy Authentication Required",
            418 => "I'm a teapot",
            421 => "Misdirected Request",
            503 => "Service Unavailable",
            511 => "Network Authentication Required"
        ];

        $nMock = new HTTPRawStatusCodeMockClass();
        foreach ($keysAndValues as $key => $value) {
            $this->assertSame($value, $nMock->getReasonPhrase($key));
        }
    }
}





class HTTPRawStatusCodeMockClass
{
    use HTTPRawStatusCode;

    public function getReasonPhrase(int $code) : ?string {
        return ((isset(self::$rawStatusCode[$code]) === true) ? self::$rawStatusCode[$code] : null);
    }
}
