<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Data\Cookie as Cookie;

require_once __DIR__ . "/../../phpunit.php";







class CookieTest extends TestCase
{





    public function test_constructor_ok()
    {
        $ckie = new Cookie("name");
        $this->assertTrue(is_a($ckie, Cookie::class));
    }


    public function test_constructor_fail()
    {
        $fail = false;
        try {
            $ckie = new Cookie("name!");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid cookie name. Use only a-zA-Z0-9 characters.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_get_name()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame("name", $ckie->getName());
    }


    public function test_method_get_value()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame("acentuação", $ckie->getValue());
        $this->assertSame("acentua%C3%A7%C3%A3o", $ckie->getValue(false));
    }


    public function test_method_get_expires()
    {
        $exp = new \DateTime();
        $exp->add(new DateInterval('P1D'));

        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame($exp->format("Y-m-d"), $ckie->getExpires()->format("Y-m-d"));
    }


    public function test_method_get_str_expires()
    {
        $exp = new \DateTime();
        $exp->add(new DateInterval('P1D'));

        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame($exp->format("D, d M Y H:i:s") . " UTC", $ckie->getStrExpires());
    }


    public function test_method_get_domain()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame("domain.com", $ckie->getDomain());
    }


    public function test_method_get_path()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame("/path", $ckie->getPath());
    }


    public function test_method_get_secure()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame(true, $ckie->getSecure());
    }


    public function test_method_get_httponly()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $this->assertSame(true, $ckie->getHttpOnly());
    }


    public function test_method_to_string()
    {
        $ckie = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
        $exp = $ckie->getStrExpires();

        $expected = "name=acentuação; Expires=$exp; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $this->assertSame($expected, $ckie->toString());

        $expected = "name=acentua%C3%A7%C3%A3o; Expires=$exp; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $this->assertSame($expected, $ckie->toString(false));
    }


    public function test_method_from_string()
    {
        $str = "name=acentua%C3%A7%C3%A3o; Expires=Fri, 10 Nov 2017 03:00:10 UTC; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $ckie = Cookie::fromString($str);

        $this->assertTrue(is_a($ckie, Cookie::class));
        $this->assertSame("name", $ckie->getName());
        $this->assertSame("acentua%C3%A7%C3%A3o", $ckie->getValue(false));
        $this->assertSame("acentuação", $ckie->getValue());
        $this->assertSame("Fri, 10 Nov 2017 03:00:10 UTC", $ckie->getStrExpires());
        $this->assertSame("domain.com", $ckie->getDomain());
        $this->assertSame("/path", $ckie->getPath());
        $this->assertSame(true, $ckie->getSecure());
        $this->assertSame(true, $ckie->getHttpOnly());


        $useDate = new DateTime();
        $expires = new \DateTime();

        $useDate->add(new DateInterval('P1D'));
        $useTime = $useDate->getTimestamp();


        $str = "name=acentua%C3%A7%C3%A3o; Expires=$useTime; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $ckie = Cookie::fromString($str);

        $this->assertTrue(is_a($ckie, Cookie::class));
        $this->assertSame("name", $ckie->getName());
        $this->assertSame("acentua%C3%A7%C3%A3o", $ckie->getValue(false));
        $this->assertSame("acentuação", $ckie->getValue());
        $this->assertSame($useDate->format("D, d M Y H:i:s") . " UTC", $ckie->getStrExpires());
        $this->assertSame("domain.com", $ckie->getDomain());
        $this->assertSame("/path", $ckie->getPath());
        $this->assertSame(true, $ckie->getSecure());
        $this->assertSame(true, $ckie->getHttpOnly());
    }


    public function test_method_from_string_fails()
    {
        $fail = false;
        try {
            $ckie = Cookie::fromString("");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("The string is not a valid representation of a cookie.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_from_raw_cookie_header()
    {
        $str = "name1=primeiro+valor%3A+rianna%40gmail.com; Expires=Fri, 10 Nov 2017 03:00:10 UTC; Domain=domain.com; Path=/path; Secure; HttpOnly;";
        $str .= "name2=valor 2; Expires=Fri, 10 Nov 2017 03:00:10 UTC; Domain=domain.com; Path=/;";
        $str .= "name3=valor 3;";
        $str .= "name4=valor 4";
        $ckie = Cookie::fromRawCookieHeader($str);

        $ckie1 = $ckie["name1"];
        $ckie2 = $ckie["name2"];
        $ckie3 = $ckie["name3"];
        $ckie4 = $ckie["name4"];


        $this->assertSame("name1", $ckie1->getName());
        $this->assertSame("primeiro%20valor%3A%20rianna%40gmail.com", $ckie1->getValue(false));
        $this->assertSame("primeiro valor: rianna@gmail.com", $ckie1->getValue());
        $this->assertSame("Fri, 10 Nov 2017 03:00:10 UTC", $ckie1->getStrExpires());
        $this->assertSame("domain.com", $ckie1->getDomain());
        $this->assertSame("/path", $ckie1->getPath());
        $this->assertSame(true, $ckie1->getSecure());
        $this->assertSame(true, $ckie1->getHttpOnly());


        $this->assertSame("name2", $ckie2->getName());
        $this->assertSame("valor%202", $ckie2->getValue(false));
        $this->assertSame("valor 2", $ckie2->getValue());
        $this->assertSame("Fri, 10 Nov 2017 03:00:10 UTC", $ckie2->getStrExpires());
        $this->assertSame("domain.com", $ckie2->getDomain());
        $this->assertSame("/", $ckie2->getPath());
        $this->assertSame(false, $ckie2->getSecure());
        $this->assertSame(false, $ckie2->getHttpOnly());

        $this->assertSame("name3", $ckie3->getName());
        $this->assertSame("valor%203", $ckie3->getValue(false));
        $this->assertSame("valor 3", $ckie3->getValue());

        $this->assertSame("name4", $ckie4->getName());
        $this->assertSame("valor%204", $ckie4->getValue(false));
        $this->assertSame("valor 4", $ckie4->getValue());
    }
}
