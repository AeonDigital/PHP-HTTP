<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Message\ServerRequest as ServerRequest;

require_once __DIR__ . "/../../phpunit.php";







class ServerRequestTest extends TestCase
{


    private $defaultURLToTest01 = "http://aeondigital.com.br/path/to/resource?param1=value1&param2=acentuação";
    private $defaultURlToTest02 = "http://aeondigital.com.br/path/to/resource?param1=first value&param2=second&param3=third&param4=fourth&param5=fifth";

    private $defaultBodyValue01 = "field1=valor 1&field2=value 2&field3=value 3&param5=value 5";




    protected function retrieveMockClassToTest($body = null, $contentType = null, $withBodyParser = false)
    {
        $oUri           = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $oHeaders       = prov_instanceOf_Http_HeaderCollection_02($contentType);
        $oBody          = prov_instanceOf_Http_Stream_fromString($body);
        $oCookies       = prov_instanceOf_Http_CookieCollection_autoSet_01();
        $oQuery         = prov_instanceOf_Http_QueryStringCollection_02($oUri);
        $oFiles         = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
        $oServerParans  = prov_assocArray_to_Http_ServerRequest();
        $oAttr          = prov_instanceOf_Collection_Collection_02();
        $oParsers       = (($withBodyParser === true) ? prov_instanceOf_Collection_Collection_03() : null);

        return new ServerRequest("get", $oUri, "1.0", $oHeaders, $oBody, $oCookies, $oQuery, $oFiles, $oServerParans, $oAttr, $oParsers);
    }












    public function test_constructor_ok()
    {
        $oUri           = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $oHeaders       = prov_instanceOf_Http_HeaderCollection_02();
        $oBody          = prov_instanceOf_Http_Stream_fromString("Test stream object");
        $oCookies       = prov_instanceOf_Http_CookieCollection_autoSet_01();
        $oQuery         = prov_instanceOf_Http_QueryStringCollection_02($oUri);
        $oFiles         = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
        $oServerParans  = prov_assocArray_to_Http_ServerRequest();
        $oAttr          = prov_instanceOf_Collection_Collection_02();

        $req = new ServerRequest("get", $oUri, "1.0", $oHeaders, $oBody, $oCookies, $oQuery, $oFiles, $oServerParans, $oAttr);
        $this->assertTrue(is_a($req, ServerRequest::class));

        $now = new DateTime();
        $this->assertSame($now->format("Y-m-d H-i"), $req->getNow()->format("Y-m-d H-i"));
    }


    public function test_constructor_fails_querystring_error()
    {
        $oUri           = prov_instanceOf_Http_Url_fromString($this->defaultURLToTest01);
        $oHeaders       = prov_instanceOf_Http_HeaderCollection_02();
        $oBody          = prov_instanceOf_Http_Stream_fromString("Test stream object");
        $oCookies       = prov_instanceOf_Http_CookieCollection_autoSet_01();
        $oQuery         = prov_instanceOf_Http_QueryStringCollection_02();
        $oFiles         = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
        $oServerParans  = prov_assocArray_to_Http_ServerRequest();
        $oAttr          = prov_instanceOf_Collection_Collection_02();


        $fail = false;
        try {
            $req = new ServerRequest("get", $oUri, "1.0", $oHeaders, $oBody, $oCookies, $oQuery, $oFiles, $oServerParans, $oAttr);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Incorrect querystring set.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_get_server_parans()
    {
        $expected = prov_assocArray_to_Http_ServerRequest();
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getServerParams());
    }


    public function test_method_get_cookie_parans()
    {
        $expected = ["cookie1" => "value 1", "cookie2" => "value 2"];
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getCookieParams());
    }


    public function test_method_get_query_parans()
    {
        $expected = ["param1" => "value1", "param2" => "acentuação"];
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getQueryParams());
    }


    public function test_method_get_uploaded_files()
    {
        $oFiles = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $result = $req->getUploadedFiles();

        $expected = $oFiles->toArray(true);

        $this->assertSame(count($expected), count($result));
        $this->assertSame($expected["file1"]->getPathToFile(), $result["file1"]->getPathToFile());
        $this->assertSame($expected["file2"]->getPathToFile(), $result["file2"]->getPathToFile());
    }


    public function test_method_get_parsed_body_empty()
    {
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "");
        $this->assertSame(null, $req->getParsedBody());

        $useBody = '{"par1":"var1","par2":"var2"}';
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $useBody, "application/json", true);
        $this->assertSame(["par1" => "var1", "par2" => "var2"], $req->getParsedBody());
    }


    public function test_method_get_parsed_body_json()
    {
        $json = '{"param1": "value1", "param2": "value2"}';
        $expected = json_decode($json, true);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $json, "application/json");
        $this->assertNotNull($req->getParsedBody());
        $this->assertSame($expected, $req->getParsedBody());
    }


    public function test_method_get_parsed_body_xml()
    {
        $xml = "<root><param>valor1</param><param>valor2</param></root>";
        $expected = simplexml_load_string($xml);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $xml, "application/xml");
        $this->assertEquals($expected, $req->getParsedBody());
    }


    public function test_method_get_parsed_body_urlencoded()
    {
        $data = "field1=value1&field2=valor e acentuação&field3=outro valor";
        parse_str($data, $expected);

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $data, "application/x-www-form-urlencoded");
        $this->assertEquals($expected, $req->getParsedBody());
    }


    public function test_method_get_attributes()
    {
        $expected = ["attribute1" => "value1", "attribute2" => "value2"];

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getAttributes());
    }


    public function test_method_get_attribute()
    {
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame("value1", $req->getAttribute("attribute1"));
    }





    public function test_method_clone_with_cookie_parans()
    {
        $expected = ["cookie1" => "value 1", "cookie2" => "value 2"];

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getCookieParams());



        $nCk1 = prov_instanceOf_Http_Cookie_autoset();
        $nCk2 = prov_instanceOf_Http_Cookie_autoset();

        $nCk1->setName("newCookie1");
        $nCk2->setName("newCookie2");

        $nCk1->setValue("new value 1");
        $nCk2->setValue("new value 2");


        $nExpected = ["newCookie1" => "new value 1", "newCookie2" => "new value 2"];
        $req1 = $req->withCookieParams([$nCk1, $nCk2]);
        $this->assertSame($nExpected, $req1->getCookieParams());
        $this->assertSame($expected, $req->getCookieParams());
    }


    public function test_method_clone_with_query_parans()
    {
        $expected = ["param1" => "value1", "param2" => "acentuação"];

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getQueryParams());
        $this->assertSame("param1=value1&param2=acentua%C3%A7%C3%A3o", $req->getUri()->getQuery());


        $nExpected = [
            "qs1" => "acentuação e espaços",
            "qs2" => "value2",
            "qs3" => "value3",
            "qs4" => "value4",
            "QS4" => "value4.1"
        ];
        $strExpected = "qs1=acentua%C3%A7%C3%A3o%20e%20espa%C3%A7os&qs2=value2&qs3=value3&qs4=value4&QS4=value4.1";
        $req1 = $req->withQueryParams($nExpected);
        $this->assertSame($nExpected, $req1->getQueryParams());
        $this->assertSame($strExpected, $req1->getUri()->getQuery());
        $this->assertSame($expected, $req->getQueryParams());
        $this->assertSame("param1=value1&param2=acentua%C3%A7%C3%A3o", $req->getUri()->getQuery());
    }


    public function test_method_clone_with_uploades_files()
    {
        $oFiles = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $result = $req->getUploadedFiles();

        $expected = $oFiles->toArray(true);

        $this->assertSame(count($expected), count($result));
        $this->assertSame($expected["file1"]->getPathToFile(), $result["file1"]->getPathToFile());
        $this->assertSame($expected["file2"]->getPathToFile(), $result["file2"]->getPathToFile());



        $newFiles = prov_instanceOf_Http_FileCollection_02(["upload-image-1-with.jpg", "upload-image-2-with.jpg"]);
        $req1 = $req->withUploadedFiles($newFiles->toArray());

        $newResult = $req1->getUploadedFiles();
        $newExpected = $newFiles->toArray(true);

        $this->assertSame(count($newExpected), count($newResult));
        $this->assertSame($newExpected["file1"]->getPathToFile(), $newResult["file1"]->getPathToFile());
        $this->assertSame($newExpected["file2"]->getPathToFile(), $newResult["file2"]->getPathToFile());

        $this->assertSame(count($expected), count($result));
        $this->assertSame($expected["file1"]->getPathToFile(), $result["file1"]->getPathToFile());
        $this->assertSame($expected["file2"]->getPathToFile(), $result["file2"]->getPathToFile());
    }


    public function test_method_clone_parsed_body()
    {
        $json = '{"param1": "value1", "param2": "value2"}';
        $expected = json_decode($json, true);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $json, "application/json", true);
        $this->assertNotNull($req->getParsedBody());
        $this->assertSame($expected, $req->getParsedBody());


        $json1 = '{"another":"value", "new": "body"}';
        $expected1 = json_decode($json1, true);
        $req1 = $req->withParsedBody($expected1);

        $this->assertNotNull($req1->getParsedBody());
        $this->assertSame($expected1, $req1->getParsedBody());

        $this->assertNotNull($req->getParsedBody());
        $this->assertSame($expected, $req->getParsedBody());
    }


    public function test_method_clone_parsed_body_fails()
    {
        $json = '{"param1": "value1", "param2": "value2"}';
        $expected = json_decode($json, true);
        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, $json, "application/json");
        $this->assertNotNull($req->getParsedBody());
        $this->assertSame($expected, $req->getParsedBody());

        $fail = false;
        try {
            $req1 = $req->withParsedBody(0);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid value defined for \"data\". Expected an array assoc, object or ``null``.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");

    }


    public function test_method_clone_with_attribute()
    {
        $expected = ["attribute1" => "value1", "attribute2" => "value2"];

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getAttributes());

        $expected1 = ["attribute1" => "value1", "attribute2" => "value2", "attribute3" => "value3"];
        $req1 = $req->withAttribute("attribute3", "value3");
        $this->assertSame($expected1, $req1->getAttributes());
        $this->assertSame($expected, $req->getAttributes());
    }


    public function test_method_clone_without_attribute()
    {
        $expected = ["attribute1" => "value1", "attribute2" => "value2"];

        $req = prov_instanceOf_Http_ServerRequest_01("GET", $this->defaultURLToTest01, "Test stream object");
        $this->assertSame($expected, $req->getAttributes());

        $expected1 = ["attribute2" => "value2"];
        $req1 = $req->withoutAttribute("attribute1");
        $this->assertSame($expected1, $req1->getAttributes());
        $this->assertSame($expected, $req->getAttributes());
    }













    public function test_method_get_method()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);
        $this->assertSame("GET", $req->getMethod());

        $req = prov_instanceOf_Http_ServerRequest_02("GET", "http://aeondigital.com.br/path/to/resource?_method=POST");
        $this->assertSame("POST", $req->getMethod());
    }


    public function test_method_get_querystrings()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);

        $this->assertSame("first value", $req->getQueryString("param1"));
        $this->assertSame("second", $req->getQueryString("param2"));
        $this->assertSame("third", $req->getQueryString("param3"));
        $this->assertSame("fourth", $req->getQueryString("param4"));
        $this->assertSame("fifth", $req->getQueryString("param5"));
        $this->assertSame(null, $req->getQueryString("not"));
    }


    public function test_method_get_posted_fields()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02, $this->defaultBodyValue01, "application/x-www-form-urlencoded; charset=utf-8");

        $postParans = $req->getPostedFields();
        $this->assertSame("valor 1", $postParans["field1"]);
        $this->assertSame("value 2", $postParans["field2"]);
        $this->assertSame("value 3", $postParans["field3"]);
        $this->assertSame("value 5", $postParans["param5"]);
    }


    public function test_method_get_post()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02, $this->defaultBodyValue01, "application/x-www-form-urlencoded; charset=utf-8");

        $this->assertSame("valor 1", $req->getPost("field1"));
        $this->assertSame("value 2", $req->getPost("field2"));
        $this->assertSame("value 3", $req->getPost("field3"));
        $this->assertSame("value 5", $req->getPost("param5"));
        $this->assertSame(null, $req->getPost("not"));
    }


    public function test_method_get_cookie()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);

        $this->assertTrue(is_a($req->getCookie("cookie1"), "AeonDigital\\Http\\Data\\Cookie"));
        $this->assertSame("value 1", $req->getCookie("cookie1")->getValue());

        $this->assertTrue(is_a($req->getCookie("cookie2"), "AeonDigital\\Http\\Data\\Cookie"));
        $this->assertSame("value 2", $req->getCookie("cookie2")->getValue());

        $this->assertTrue(is_a($req->getCookie("field3"), "AeonDigital\\Http\\Data\\Cookie"));
        $this->assertSame("not overwrited cookie", $req->getCookie("field3")->getValue());

        $this->assertNull($req->getCookie("not"));
    }


    public function test_method_get_cookie_value()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);

        $this->assertSame("value 1", $req->getCookieValue("cookie1"));
        $this->assertSame("value 2", $req->getCookieValue("cookie2"));
        $this->assertSame("not overwrited cookie", $req->getCookieValue("field3"));
        $this->assertSame(null, $req->getCookieValue("not"));
    }


    public function test_method_get_param()
    {
        $req = prov_instanceOf_Http_ServerRequest_02(
            "GET",
            $this->defaultURlToTest02,
            $this->defaultBodyValue01,
            "application/x-www-form-urlencoded"
        );
        $req->setInitialAttributes([
            "urlAttr1" => "value a1",
            "urlAttr2" => "value a2",
            "field3" => "try overwrite"
        ]);
        $this->assertSame(null, $req->getParam("not"));


        // cookies
        $this->assertSame("value 1", $req->getParam("cookie1"));
        $this->assertSame("value 2", $req->getParam("cookie2"));
        $this->assertSame("not overwrited cookie", $req->getParam("field3"));


        // attributes
        $this->assertSame("value a1", $req->getParam("urlAttr1"));
        $this->assertSame("value a2", $req->getParam("urlAttr2"));
        $this->assertSame("not overwrited cookie", $req->getParam("field3"));


        // Querystrings
        $this->assertSame("first value", $req->getParam("param1"));
        $this->assertSame("second", $req->getParam("param2"));
        $this->assertSame("third", $req->getParam("param3"));
        $this->assertSame("fourth", $req->getParam("param4"));
        $this->assertSame("fifth", $req->getParam("param5"));


        // dados postados no corpo da requisição
        $this->assertSame("valor 1", $req->getParam("field1"));
        $this->assertSame("value 2", $req->getParam("field2"));
        $this->assertSame("not overwrited cookie", $req->getParam("field3"));
        $this->assertSame("fifth", $req->getParam("param5"));
    }


    public function test_method_set_initial_attributes()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);
        $req->setInitialAttributes([
            "attr1" => "value1",
            "attr2" => "value2",
            "attr3" => "value3",
            "attr4" => "value4"
        ]);

        $this->assertSame("value1", $req->getAttribute("attr1"));
        $this->assertSame("value2", $req->getAttribute("attr2"));
        $this->assertSame("value3", $req->getAttribute("attr3"));
        $this->assertSame("value4", $req->getAttribute("attr4"));
        $this->assertSame(null, $req->getAttribute("attr5"));


        $req->setInitialAttributes([
            "attr5" => "value5",
            "attr6" => "value6",
            "attr7" => "value7",
            "attr8" => "value8"
        ]);

        $this->assertSame(null, $req->getAttribute("attr5"));
        $this->assertSame(null, $req->getAttribute("attr6"));
        $this->assertSame(null, $req->getAttribute("attr7"));
        $this->assertSame(null, $req->getAttribute("attr8"));
    }


    public function test_method_clone_with_attribute_02()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);
        $req->setInitialAttributes([
            "attr1" => "value1",
            "attr2" => "value2",
            "attr3" => "value3",
            "attr4" => "value4"
        ]);

        $this->assertSame("value1", $req->getAttribute("attr1"));
        $this->assertSame("value2", $req->getAttribute("attr2"));
        $this->assertSame("value3", $req->getAttribute("attr3"));
        $this->assertSame("value4", $req->getAttribute("attr4"));
        $this->assertSame(null, $req->getAttribute("attr5"));

        $req = $req->withAttribute("attr5", "value5");
        $this->assertSame("value1", $req->getAttribute("attr1"));
        $this->assertSame("value2", $req->getAttribute("attr2"));
        $this->assertSame("value3", $req->getAttribute("attr3"));
        $this->assertSame("value4", $req->getAttribute("attr4"));
        $this->assertSame("value5", $req->getAttribute("attr5"));
    }


    public function test_method_clone_without_attribute_02()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);
        $req->setInitialAttributes([
            "attr1" => "value1",
            "attr2" => "value2",
            "attr3" => "value3",
            "attr4" => "value4"
        ]);

        $this->assertSame("value1", $req->getAttribute("attr1"));
        $this->assertSame("value2", $req->getAttribute("attr2"));
        $this->assertSame("value3", $req->getAttribute("attr3"));
        $this->assertSame("value4", $req->getAttribute("attr4"));
        $this->assertSame(null, $req->getAttribute("attr5"));

        $req = $req->withoutAttribute("attr4");
        $this->assertSame("value1", $req->getAttribute("attr1"));
        $this->assertSame("value2", $req->getAttribute("attr2"));
        $this->assertSame("value3", $req->getAttribute("attr3"));
        $this->assertSame(null, $req->getAttribute("attr4"));
        $this->assertSame(null, $req->getAttribute("attr5"));
    }


    public function test_method_getset_response_mimes()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02, null, "application/xhtml+xml");

        $headerLineAccept = "text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8";
        $this->assertSame($headerLineAccept, $req->getHeaderLine("accept"));

        $expected = [
            [ "mime" => "html",     "mimetype" => "text/html" ],
            [ "mime" => "xhtml",    "mimetype" => "application/xhtml+xml" ],
            [ "mime" => "xml",      "mimetype" => "application/xml" ],
            [ "mime" => "*/*",      "mimetype" => "*/*" ]
        ];
        $this->assertSame($expected, $req->getResponseMimes());
    }


    public function test_method_getset_response_locales()
    {
        $req = prov_instanceOf_Http_ServerRequest_02("GET", $this->defaultURlToTest02);

        $headerLineAcceptLanguage = "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3";
        $this->assertSame($headerLineAcceptLanguage, $req->getHeaderLine("accept-language"));

        $expected = ["pt-br", "en-us"];
        $this->assertSame($expected, $req->getResponseLocales());

        $expected = ["pt", "en"];
        $this->assertSame($expected, $req->getResponseLanguages());
    }
}
