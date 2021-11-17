<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\CookieCollection as CookieCollection;

require_once __DIR__ . "/../../phpunit.php";







class CookieCollectionTest extends TestCase
{





    public function test_constructor_ok()
    {
        $ckie = new CookieCollection();
        $this->assertTrue(is_a($ckie, CookieCollection::class));
    }


    public function test_constructor_ok_with_values()
    {
        $ck1 = prov_instanceOf_Http_Cookie_autoset();
        $ck2 = prov_instanceOf_Http_Cookie_autoset();

        $ck1->setName("cookie1");
        $ck2->setName("cookie2");

        $ck1->setValue("value 1");
        $ck2->setValue("value 2");

        $ckie = new CookieCollection(["ck1" => $ck1, "ck2" => $ck2]);
        $this->assertTrue(is_a($ckie, CookieCollection::class));
    }


    public function test_constructor_initial_values_fail()
    {
        $fail = false;
        try {
            $ckie = new CookieCollection(["key1" => "value1"]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value. Expected instance to implement interface AeonDigital\Interfaces\Http\Data\iCookie.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_get()
    {
        $ckie = prov_instanceOf_Http_CookieCollection_autoSet_01();

        $this->assertSame("value 1", $ckie->get("cookie1")->getValue());
        $this->assertSame("value 2", $ckie->get("cookie2")->getValue());
    }


    public function test_method_to_string()
    {
        $ckie = prov_instanceOf_Http_CookieCollection_autoSet_01();
        $exp = $ckie->get("cookie1")->getStrExpires();

        $expected = "cookie1=value 1; Expires=$exp; Domain=domain.com; Path=/path; Secure; HttpOnly; ";
        $expected .= "cookie2=value 2; Expires=$exp; Domain=domain.com; Path=/path; Secure; HttpOnly;";

        $this->assertSame($expected, $ckie->toString());
    }


    public function test_method_to_array()
    {
        $ckie = prov_instanceOf_Http_CookieCollection_autoSet_01();
        $cookies = $ckie->toArray(true);

        $this->assertSame(2, count($cookies));
        $this->assertSame("value 1", $cookies["cookie1"]->getValue());
        $this->assertSame("value 2", $cookies["cookie2"]->getValue());
    }


    public function test_method_from_raw_cookie_header()
    {
        $str = "name1=valor 1; Expires=Fri, 10 Nov 2017 03:00:10 UTC; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $str .= "name2=valor 2; Expires=Fri, 10 Nov 2017 03:00:10 UTC; Domain=domain.com; Path=/;";
        $str .= "name3=valor 3;";
        $str .= "name4=valor 4";
        $ckie = CookieCollection::fromString($str);

        $ckie1 = $ckie["name1"];
        $ckie2 = $ckie["name2"];
        $ckie3 = $ckie["name3"];
        $ckie4 = $ckie["name4"];

        $this->assertSame("name1", $ckie1->getName());
        $this->assertSame("valor 1", $ckie1->getValue());
        $this->assertSame("Fri, 10 Nov 2017 03:00:10 UTC", $ckie1->getStrExpires());
        $this->assertSame("domain.com", $ckie1->getDomain());
        $this->assertSame("/path", $ckie1->getPath());
        $this->assertSame(true, $ckie1->getSecure());
        $this->assertSame(true, $ckie1->getHttpOnly());


        $this->assertSame("name2", $ckie2->getName());
        $this->assertSame("valor 2", $ckie2->getValue());
        $this->assertSame("Fri, 10 Nov 2017 03:00:10 UTC", $ckie2->getStrExpires());
        $this->assertSame("domain.com", $ckie2->getDomain());
        $this->assertSame("/", $ckie2->getPath());
        $this->assertSame(false, $ckie2->getSecure());
        $this->assertSame(false, $ckie2->getHttpOnly());

        $this->assertSame("name3", $ckie3->getName());
        $this->assertSame("valor 3", $ckie3->getValue());

        $this->assertSame("name4", $ckie4->getName());
        $this->assertSame("valor 4", $ckie4->getValue());
    }
}
