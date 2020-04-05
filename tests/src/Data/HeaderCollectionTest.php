<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\HeaderCollection as HeaderCollection;

require_once __DIR__ . "/../../phpunit.php";







class HeaderCollectionTest extends TestCase
{



    public function test_constructor_ok()
    {
        $head = new HeaderCollection();
        $this->assertTrue(is_a($head, HeaderCollection::class));
    }


    public function test_constructor_initial_values_fail()
    {
        $head = new HeaderCollection(["teste" => new \DateTime()]);
        $this->assertFalse($head->has("teste"));


        $head = new HeaderCollection(["teste" => ["primeiro valor", new \DateTime()]]);
        $this->assertFalse($head->has("teste"));
    }


    public function test_method_get_headers()
    {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $head = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $oHeaders = $head->toArray();
        $this->assertTrue(is_array($oHeaders));
        $this->assertTrue(isset($oHeaders["Content-Type"]));
        $this->assertTrue(isset($oHeaders["Teste"]));

        $this->assertTrue(isset($head["CONTENT-TYPE"]));
        $this->assertTrue(isset($head["Content-Type"]));
        $this->assertTrue(isset($head["teste"]));

        $this->assertSame(["value1", "value2"], $head->get("Content-Type"));
        $this->assertSame(["text/html", "application/xhtml+xml", "application/xml;q=0.9", "*/*;q=0.8"], $head->get("teste"));

        $this->assertSame(["value1", "value2"], $head["Content-Type"]);
        $this->assertSame(["text/html", "application/xhtml+xml", "application/xml;q=0.9", "*/*;q=0.8"], $head["teste"]);
    }


    public function test_method_get_header_line()
    {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $head = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $this->assertSame("value1, value2", $head->getHeaderLine("Content-Type"));
        $this->assertSame("text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8", $head->getHeaderLine("teste"));
    }


    public function test_method_has_headers()
    {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $head = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $this->assertTrue($head->has("CONTENT-TYPE"));
        $this->assertTrue($head->has("teste"));
        $this->assertTrue($head->has("Content-Type"));
        $this->assertTrue($head->has("Teste"));
        $this->assertTrue($head->has("TESTE"));
        $this->assertTrue($head->has("content type"));
        $this->assertFalse($head->has("content type error"));
    }


    public function test_method_set_headers()
    {
        $head = provider_PHPHTTPData_InstanceOf_HeaderCollection();
        $head->set("Teste", "valor1, valor2");
        $this->assertSame(["valor1", "valor2"], $head->get("teste"));

        $head->set("Teste", "valor3");
        $this->assertSame(["valor1", "valor2", "valor3"], $head->get("teste"));
    }


    public function test_method_to_string()
    {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $expected = "Content-Type: value1, value2\nTeste: text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8";

        $head = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);
        $this->assertSame($expected, $head->toString());
    }


    public function test_constructor_from_string()
    {
        $str = "Content-Type: value1, value2\nTeste: text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8";

        $head = HeaderCollection::fromString($str);
        $this->assertTrue(is_a($head, HeaderCollection::class));

        $this->assertSame(["value1", "value2"], $head->get("Content-Type"));
    }


    public function test_constructor_from_string_fail()
    {
        $fail = false;
        try {
            $str = "Content-Type: value1, value2\nTeste";
            $head = HeaderCollection::fromString($str);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given value. Cant convert to headers collection.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
}
