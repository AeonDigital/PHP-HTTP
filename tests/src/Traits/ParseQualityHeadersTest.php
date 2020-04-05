<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Traits\ParseQualityHeaders as ParseQualityHeaders;

require_once __DIR__ . "/../../phpunit.php";







class ParseQualityHeadersTest extends TestCase
{



    public function test_method_parseArrayOfQualityHeaders()
    {
        $nMock = new ParseQualityHeadersMockClass();
        $this->assertNull($nMock->parseArrayOfQualityHeaders(null));

        $rawHeaders = [
            " text/html ",
            " application/xhtml+xml ",
            "application/xml ; q=0.9",
            "* /* ; q=0.8"
        ];
        $result = $nMock->parseArrayOfQualityHeaders($rawHeaders);



        $expectedResult = [
            [
                "value" => "text/html",
                "quality" => 1
            ],
            [
                "value" => "application/xhtml+xml",
                "quality" => 1
            ],
            [
                "value" => "application/xml",
                "quality" => 0.9
            ],
            [
                "value" => "* /*",
                "quality" => 0.8
            ]
        ];

        foreach ($expectedResult as $i => $resultData) {
            $this->assertEquals($expectedResult[$i]["value"], $result[$i]["value"]);
            $this->assertEquals($expectedResult[$i]["quality"], $result[$i]["quality"]);
        }
    }



    public function test_method_parseRawLineOfQualityHeaders()
    {
        $nMock = new ParseQualityHeadersMockClass();
        $this->assertNull($nMock->parseRawLineOfQualityHeaders(null));
        $this->assertNull($nMock->parseRawLineOfQualityHeaders(""));

        $rawHeaders = "text/html,application/xhtml+xml,application/xml;q=0.9,* /*;q=0.8";
        $result = $nMock->parseRawLineOfQualityHeaders($rawHeaders);



        $expectedResult = [
            [
                "value" => "text/html",
                "quality" => 1
            ],
            [
                "value" => "application/xhtml+xml",
                "quality" => 1
            ],
            [
                "value" => "application/xml",
                "quality" => 0.9
            ],
            [
                "value" => "* /*",
                "quality" => 0.8
            ]
        ];

        foreach ($expectedResult as $i => $resultData) {
            $this->assertEquals($expectedResult[$i]["value"], $result[$i]["value"]);
            $this->assertEquals($expectedResult[$i]["quality"], $result[$i]["quality"]);
        }





        $rawHeaders = "pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3";
        $result = $nMock->parseRawLineOfQualityHeaders($rawHeaders);



        $expectedResult = [
            [
                "value" => "pt-BR",
                "quality" => 1
            ],
            [
                "value" => "pt",
                "quality" => 0.8
            ],
            [
                "value" => "en-US",
                "quality" => 0.5
            ],
            [
                "value" => "en",
                "quality" => 0.3
            ]
        ];

        foreach ($expectedResult as $i => $resultData) {
            $this->assertEquals($expectedResult[$i]["value"], $result[$i]["value"]);
            $this->assertEquals($expectedResult[$i]["quality"], $result[$i]["quality"]);
        }
    }



    public function test_method_parseArrayOfHeaderAcceptLanguage()
    {
        $nMock = new ParseQualityHeadersMockClass();
        $this->assertNull($nMock->parseArrayOfHeaderAcceptLanguage(null));
        $this->assertNull($nMock->parseArrayOfHeaderAcceptLanguage([]));

        $rawHeaders = [
            "pt-BR",
            "pt;q=0.8",
            "en-US;q=0.5",
            "en;q=0.3"
        ];
        $result = $nMock->parseArrayOfHeaderAcceptLanguage($rawHeaders);



        $expectedResult = [
            "locales" => ["pt-br", "en-us"],
            "languages" => ["pt", "en"],
        ];

        $this->assertEquals($expectedResult["locales"], $result["locales"]);
        $this->assertEquals($expectedResult["languages"], $result["languages"]);
    }



    public function test_method_parseRawLineOfHeaderAcceptLanguage()
    {
        $nMock = new ParseQualityHeadersMockClass();
        $this->assertNull($nMock->parseRawLineOfHeaderAcceptLanguage(null));
        $this->assertNull($nMock->parseRawLineOfHeaderAcceptLanguage(""));

        $rawHeaders = "pt-BR , pt ; q=0.8, en-US ; q=0.5 , en ; q=0.3";
        $result = $nMock->parseRawLineOfHeaderAcceptLanguage($rawHeaders);



        $expectedResult = [
            "locales" => ["pt-br", "en-us"],
            "languages" => ["pt", "en"],
        ];

        $this->assertEquals($expectedResult["locales"], $result["locales"]);
        $this->assertEquals($expectedResult["languages"], $result["languages"]);
    }
}





class ParseQualityHeadersMockClass
{
    use ParseQualityHeaders;
}
