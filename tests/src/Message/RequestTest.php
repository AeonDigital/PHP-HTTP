<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Message\Request as Request;

require_once __DIR__ . "/../../phpunit.php";







class RequestTest extends TestCase
{


    private $defaultURLToTest01 = "http://aeondigital.com.br/path/to/resource?param1=value1&param2=acentuação";
    private $defaultURLToTest02 = "http://domain.com/another/path/to/resource?param=value";





    public function test_constructor_http_version_fail()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $fail = false;
        try {
            $req = new Request("gett", $oUri, "1.0", $oHeaders, $oBody);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"method\". Expected [ GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS, TRACE, DEV, CONNECT ]. Given: [ gett ]", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $req = new Request("get", $oUri, "1.0", $oHeaders, $oBody);
        $this->assertTrue(is_a($req, Request::class));
    }


    public function test_method_get_method()
    {
        $req = prov_instanceOf_Http_Request("get", $this->defaultURLToTest01);
        $this->assertSame("GET", $req->getMethod());
    }


    public function test_method_get_uri()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $req = prov_instanceOf_Http_Request("get", $oUri, "1.0", $oHeaders, $oBody);
        $this->assertSame($oUri, $req->getUri());
    }


    public function test_method_get_request_target()
    {
        $req = prov_instanceOf_Http_Request("get", $this->defaultURLToTest01);
        $this->assertSame("/path/to/resource?param1=value1&param2=acentua%C3%A7%C3%A3o", $req->getRequestTarget());
    }





    public function test_method_clone_with_method()
    {
        $req = prov_instanceOf_Http_Request("get", $this->defaultURLToTest01);
        $this->assertSame("GET", $req->getMethod());

        $req1 = $req->withMethod("put");
        $this->assertSame("PUT", $req1->getMethod());
        $this->assertSame("GET", $req->getMethod());
    }


    public function test_method_clone_with_uri()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $req = prov_instanceOf_Http_Request("get", $oUri, "1.0", $oHeaders, $oBody);
        $this->assertSame("GET", $req->getMethod());


        $oUri1 = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest02);
        $req1 = $req->withUri($oUri1);
        $this->assertSame($oUri, $req->getUri());
        $this->assertSame($oUri1, $req1->getUri());


        $this->assertSame("aeondigital.com.br", $req->getHeaderLine("host"));
        $this->assertSame("domain.com", $req1->getHeaderLine("host"));
    }


    public function test_method_clone_with_uri_preserve_host()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $req = prov_instanceOf_Http_Request("get", $oUri, "1.0", $oHeaders, $oBody);
        $this->assertSame("GET", $req->getMethod());


        $oUri1 = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest02);
        $req1 = $req->withUri($oUri1, true);
        $this->assertSame($oUri, $req->getUri());
        $this->assertSame($oUri1, $req1->getUri());

        $this->assertSame("aeondigital.com.br", $req->getHeaderLine("host"));
        $this->assertSame("aeondigital.com.br", $req1->getHeaderLine("host"));
    }


    public function test_method_clone_with_request_target()
    {
        $oUri       = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $headers    = prov_assocArray_to_Http_Header_01();
        $oHeaders   = prov_instanceOf_Http_HeaderCollection_01($headers);
        $oBody      = prov_instanceOf_Http_Stream_fromString("Test stream object");

        $req = prov_instanceOf_Http_Request("get", $oUri, "1.0", $oHeaders, $oBody);
        $this->assertSame("GET", $req->getMethod());


        $req1 = $req->withRequestTarget("/another/path/to/resource?another=value1&param=value2");
        $this->assertSame("/another/path/to/resource?another=value1&param=value2", $req1->getRequestTarget());
        $this->assertSame("/path/to/resource?param1=value1&param2=acentua%C3%A7%C3%A3o", $req->getRequestTarget());


        $req2 = $req->withRequestTarget("/simple/path");
        $this->assertSame("/simple/path", $req2->getRequestTarget());
        $this->assertSame("/another/path/to/resource?another=value1&param=value2", $req1->getRequestTarget());
        $this->assertSame("/path/to/resource?param1=value1&param2=acentua%C3%A7%C3%A3o", $req->getRequestTarget());
    }
}
