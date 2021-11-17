<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\QueryStringCollection as QueryStringCollection;

require_once __DIR__ . "/../../phpunit.php";







class QueryStringCollectionTest extends TestCase
{



    public function test_constructor_ok()
    {
        $head = new QueryStringCollection();
        $this->assertTrue(is_a($head, QueryStringCollection::class));
    }


    public function test_constructor_initial_values_fail()
    {
        $head = new QueryStringCollection(["teste" => new \DateTime()]);
        $this->assertFalse($head->has("Teste"));
    }


    public function test_method_get_querystrings()
    {
        $baseQS = prov_assocArray_to_Http_QueryString_01();
        $qs = prov_instanceOf_Http_QueryStringCollection_01($baseQS);

        $arrQS = $qs->toArray();
        $this->assertTrue(is_array($arrQS));
        $this->assertTrue(isset($arrQS["qs1"]));
        $this->assertTrue(isset($arrQS["qs2"]));
        $this->assertTrue(isset($arrQS["qs3"]));
        $this->assertTrue(isset($arrQS["qs4"]));
        $this->assertTrue(isset($arrQS["QS4"]));
        $this->assertFalse(isset($arrQS["Qs4"]));
        $this->assertFalse(isset($arrQS["qS4"]));
        $this->assertFalse(isset($arrQS["qs5"]));

        $this->assertTrue(isset($qs["qs1"]));
        $this->assertTrue(isset($qs["qs2"]));
        $this->assertTrue(isset($qs["qs3"]));
        $this->assertTrue(isset($qs["qs4"]));
        $this->assertTrue(isset($qs["QS4"]));
        $this->assertFalse(isset($qs["Qs4"]));
        $this->assertFalse(isset($qs["qS4"]));
        $this->assertFalse(isset($qs["qs5"]));

        $this->assertSame("acentua%C3%A7%C3%A3o%20e%20espa%C3%A7os", $qs->get("qs1"));
        $this->assertSame("value2", $qs->get("qs2"));
        $this->assertSame("value3", $qs->get("qs3"));
        $this->assertSame("value4", $qs->get("qs4"));
        $this->assertSame("value4.1%20and", $qs->get("QS4"));

        $this->assertSame("acentua%C3%A7%C3%A3o%20e%20espa%C3%A7os", $qs["qs1"]);
        $this->assertSame("value2", $qs["qs2"]);
        $this->assertSame("value3", $qs["qs3"]);
        $this->assertSame("value4", $qs["qs4"]);
        $this->assertSame("value4.1%20and", $qs["QS4"]);
    }


    public function test_method_not_use_percent_encode()
    {
        $baseQS = prov_assocArray_to_Http_QueryString_01();
        $qs = prov_instanceOf_Http_QueryStringCollection_01($baseQS);

        $arrQS = $qs->toArray();
        $this->assertSame("acentua%C3%A7%C3%A3o%20e%20espa%C3%A7os", $qs->get("qs1"));

        $qs->usePercentEncode(false);
        $this->assertSame("acentuação e espaços", $qs["qs1"]);
    }


    public function test_method_has_querystrings()
    {
        $baseQS = prov_assocArray_to_Http_QueryString_01();
        $qs = prov_instanceOf_Http_QueryStringCollection_01($baseQS);

        $this->assertTrue($qs->has("qs1"));
        $this->assertTrue($qs->has("qs2"));
        $this->assertTrue($qs->has("qs3"));
        $this->assertTrue($qs->has("qs4"));
        $this->assertTrue($qs->has("QS4"));
        $this->assertFalse($qs->has("querystring"));
    }


    public function test_method_to_string()
    {
        $baseQS = prov_assocArray_to_Http_QueryString_01();
        $qs = prov_instanceOf_Http_QueryStringCollection_01($baseQS);

        $expected = "qs1=acentua%C3%A7%C3%A3o%20e%20espa%C3%A7os&qs2=value2&qs3=value3&qs4=value4&QS4=value4.1%20and";

        $this->assertSame($expected, $qs->toString());
    }


    public function test_constructor_from_string()
    {
        $str = "qs1=value1&qs2=value2&qs3=value3&qs4=value4&QS4=value4.1";

        $qs = QueryStringCollection::fromString($str);
        $this->assertTrue(is_a($qs, QueryStringCollection::class));

        $this->assertSame("value4.1", $qs->get("QS4"));
    }
}
