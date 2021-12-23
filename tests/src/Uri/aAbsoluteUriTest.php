<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Uri\Tests\Concrete\AbsoluteUri as AbsoluteUri;

require_once __DIR__ . "/../../phpunit.php";







class aAbsoluteUriTest extends TestCase
{



    public function test_constructor_ok()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment/segment&/seg-ment",
            "par1=val#lue&PAR2=m!sturall",
            "sam3d^oc§s"
        );
        $this->assertTrue(is_a($nMock, AbsoluteUri::class));
    }


    public function test_method_get_query()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());
    }


    public function test_method_get_fragment()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());
    }


    public function test_method_clone_with_query()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());


        $nMock2 = $nMock->withQuery("anpar=another#%paramvalue");
        $this->assertSame("anpar=another%23%25paramvalue", $nMock2->getQuery());
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());
    }


    public function test_method_clone_with_query_fail()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());


        $fail = false;
        try {
            $nMock2 = $nMock->withQuery(1);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"query\". Expected string. Given: [ 1 ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_with_fragment()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());


        $nMock2 = $nMock->withFragment("newfragment");
        $this->assertSame("newfragment", $nMock2->getFragment());
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());
    }


    public function test_method_clone_with_fragment_fail()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());


        $fail = false;
        try {
            $nMock2 = $nMock->withFragment(["fragment"]);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"fragment\". Expected string. Given: [ fragment ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_with_relative_uri()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("segment%24/segment%26/seg-ment", $nMock->getPath());
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());


        $nMock2 = $nMock->withRelativeUri("/another/path", "testparam=valueparam", "");
        $this->assertSame("/another/path", $nMock2->getPath());
        $this->assertSame("testparam=valueparam", $nMock2->getQuery());
        $this->assertSame("", $nMock2->getFragment());

        $this->assertSame("segment%24/segment%26/seg-ment", $nMock->getPath());
        $this->assertSame("par1=val%23lue&PAR2=m%21stur%28all", $nMock->getQuery());
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());
    }


    public function test_method_get_absolute_uri()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("https://username:pass1%40234@testdomain:455/segment%24/segment%26/seg-ment?par1=val%23lue&PAR2=m%21stur%28all", $nMock->getAbsoluteUri());
    }


    public function test_method_get_absolute_uri_with_fragment()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("https://username:pass1%40234@testdomain:455/segment%24/segment%26/seg-ment?par1=val%23lue&PAR2=m%21stur%28all#sam3d%5Eoc%C2%A7s", $nMock->getAbsoluteUri(true));
    }


    public function test_method_get_relative_uri()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("segment%24/segment%26/seg-ment?par1=val%23lue&PAR2=m%21stur%28all", $nMock->getRelativeUri());
    }


    public function test_method_get_relative_uri_with_fragment()
    {
        $nMock = new AbsoluteUri(
            "https",
            "username",
            "pass1@234",
            "testdomain",
            455,
            "segment$/segment&/seg-ment",
            "par1=val#lue&PAR2=m!stur(all",
            "sam3d^oc§s"
        );
        $this->assertSame("segment%24/segment%26/seg-ment?par1=val%23lue&PAR2=m%21stur%28all#sam3d%5Eoc%C2%A7s", $nMock->getRelativeUri(true));
    }


    public function test_method_from_string()
    {
        $uri = "https://username:pass1234@testdomain:455/segment/segment&/seg-ment?par1=vallue&PAR2=m!stur(all#sam3d^oc§s";
        $nMock = AbsoluteUri::fromString($uri);

        $this->assertSame("https", $nMock->getScheme());
        $this->assertSame("username", $nMock->getUser());
        $this->assertSame("pass1234", $nMock->getPassword());
        $this->assertSame("testdomain", $nMock->getHost());
        $this->assertSame(455, $nMock->getPort());
        $this->assertSame("/segment/segment%26/seg-ment", $nMock->getPath());
        $this->assertSame("par1=vallue&PAR2=m%21stur%28all", $nMock->getQuery());
        $this->assertSame("sam3d%5Eoc%C2%A7s", $nMock->getFragment());

        $this->assertSame("https://username:pass1234@testdomain:455/segment/segment%26/seg-ment?par1=vallue&PAR2=m%21stur%28all", $nMock->getAbsoluteUri());
        $this->assertSame("https://username:pass1234@testdomain:455/segment/segment%26/seg-ment?par1=vallue&PAR2=m%21stur%28all#sam3d%5Eoc%C2%A7s", $nMock->getAbsoluteUri(true));
        $this->assertSame("/segment/segment%26/seg-ment?par1=vallue&PAR2=m%21stur%28all", $nMock->getRelativeUri());
        $this->assertSame("/segment/segment%26/seg-ment?par1=vallue&PAR2=m%21stur%28all#sam3d%5Eoc%C2%A7s", $nMock->getRelativeUri(true));
    }


    public function test_method_to_string()
    {
        $uri = "https://username:pass1234@testdomain:455/segment/segment&/seg-ment?par1=vallue&PAR2=m!stur(all#sam3d^oc§s";
        $nMock = AbsoluteUri::fromString($uri);

        $strUri = (string)$nMock;
        $this->assertSame($strUri, $nMock->getAbsoluteUri(true));


        $uri = "http://localhost:8080/";
        $nMock = AbsoluteUri::fromString($uri);

        $strUri = (string)$nMock;
        $this->assertSame($strUri, $nMock->getAbsoluteUri(true));

    }
}
