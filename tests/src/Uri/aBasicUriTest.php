<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Uri\Tests\Concrete\BasicUri as BasicUri;

require_once __DIR__ . "/../../phpunit.php";







class aBasicUriTest extends TestCase
{



    public function test_constructor_invalid_scheme_value()
    {
        $fail = false;
        try {
            $nMock = new BasicUri("htt", [""]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"scheme\" value [ \"htt\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        $nMock = new BasicUri("http", ["http", "https", "ftp"]);
        $this->assertTrue(is_a($nMock, BasicUri::class));
    }


    public function test_method_get_scheme()
    {
        $nMock = new BasicUri("HTTPS", ["http", "https", "ftp"]);
        $this->assertSame("https", $nMock->getScheme());
    }


    public function test_method_clone_with_scheme()
    {
        $nMock = new BasicUri("HTTPS", ["http", "https", "ftp"]);
        $this->assertSame("https", $nMock->getScheme());


        $nMock2 = $nMock->withScheme("HtTp");
        $this->assertSame("http", $nMock2->getScheme());
        $this->assertSame("https", $nMock->getScheme());
    }


    public function test_method_clone_with_scheme_fail()
    {
        $nMock = new BasicUri("HTTPS", ["http", "https", "ftp"]);
        $this->assertSame("https", $nMock->getScheme());


        $fail = false;
        try {
            $nMock2 = $nMock->withScheme([], ["http", "https", "ftp"]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"scheme\" value. Must be an string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }
}
