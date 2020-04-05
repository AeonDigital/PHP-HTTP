<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\Http\Message\Tests\Concrete\Message as Message;

require_once __DIR__ . "/../../phpunit.php";







class aMessageTest extends TestCase
{





    public function test_constructor_http_version_fail()
    {
        $oStream = provider_PHPStream_InstanceOf_Stream_FromText("Test stream object");
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $oHeaders = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $fail = false;
        try {
            $httpMsg = new Message("1.5", $oHeaders, $oStream);
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"protocolVersion\" value. [ \"1.5\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_constructor_ok()
    {
        $oStream = provider_PHPStream_InstanceOf_Stream_FromText("Test stream object");
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $oHeaders = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $httpMsg = new Message("1.1", $oHeaders, $oStream);
        $this->assertTrue(is_a($httpMsg, Message::class));
    }


    public function test_method_get_protocol_version()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message("1.1");
        $this->assertSame("1.1", $httpMsg->getProtocolVersion());
    }


    public function test_method_get_headers()
    {
        $oStream = provider_PHPStream_InstanceOf_Stream_FromText("Test stream object");
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $oHeaders = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message("1.1", $oHeaders, $oStream);
        $oHeaders = $httpMsg->getHeaders();

        $this->assertTrue(is_array($oHeaders));
        $this->assertTrue(isset($oHeaders["CONTENT_TYPE"]));
        $this->assertTrue(isset($oHeaders["teste"]));
        $this->assertSame(["value1", "value2"], $oHeaders["CONTENT_TYPE"]);
        $this->assertSame(["text/html", "application/xhtml+xml", "application/xml;q=0.9", "*/*;q=0.8"], $oHeaders["teste"]);
    }


    public function test_method_has_headers()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();

        $this->assertTrue($httpMsg->hasHeader("CONTENT_TYPE"));
        $this->assertTrue($httpMsg->hasHeader("teste"));
        $this->assertTrue($httpMsg->hasHeader("Content-Type"));
        $this->assertTrue($httpMsg->hasHeader("Teste"));
        $this->assertTrue($httpMsg->hasHeader("TESTE"));
        $this->assertTrue($httpMsg->hasHeader("content type"));
        $this->assertFalse($httpMsg->hasHeader("content type error"));
    }


    public function test_method_get_header()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));
        $this->assertSame([], $httpMsg->getHeader("Content-Types"));
    }


    public function test_method_get_header_line()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame("value1, value2", $httpMsg->getHeaderLine("Content-Type"));
        $this->assertSame("", $httpMsg->getHeaderLine("Content-Types"));
        $this->assertSame("text/html, application/xhtml+xml, application/xml;q=0.9, */*;q=0.8", $httpMsg->getHeaderLine("TESTE"));
    }


    public function test_method_get_body()
    {
        $oStream = provider_PHPStream_InstanceOf_Stream_FromText("Test stream object");
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $oHeaders = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message("1.1", $oHeaders, $oStream);
        $this->assertSame($oStream, $httpMsg->getBody());
    }


    public function test_method_clone_with_protocol_version()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame("1.1", $httpMsg->getProtocolVersion());

        $httpMsg1 = $httpMsg->withProtocolVersion("2.0");
        $this->assertSame("2.0", $httpMsg1->getProtocolVersion());
        $this->assertSame("1.1", $httpMsg->getProtocolVersion());
    }


    public function test_method_clone_with_protocol_version_fail()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();

        $fail = false;
        try {
            $httpMsg = $httpMsg->withProtocolVersion(null, "valor");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"protocolVersion\" value. Must be an string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_with_header()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));

        $httpMsg1 = $httpMsg->withHeader("Content-Type", "novovalor, outrovalor");
        $this->assertSame(["novovalor", "outrovalor"], $httpMsg1->getHeader("Content-Type"));
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));
    }


    public function test_method_clone_with_header_fail()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();

        $fail = false;
        try {
            $httpMsg = $httpMsg->withHeader(null, "valor");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"name\" value. Must be a non empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_with_added_header()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));


        $httpMsg1 = $httpMsg->withAddedHeader("Content-Type", "value3");
        $this->assertSame("value1, value2, value3", $httpMsg1->getHeaderLine("Content-Type"));
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));


        $httpMsg2 = $httpMsg->withAddedHeader("Content-Type", ["value2", "value3", "value4"]);
        $this->assertSame("value1, value2, value3, value4", $httpMsg2->getHeaderLine("Content-Type"));
        $this->assertSame("value1, value2, value3", $httpMsg1->getHeaderLine("Content-Type"));
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));


        $httpMsg3 = $httpMsg->withAddedHeader("Content-Length", ["one", "two", "three"]);
        $this->assertSame("one, two, three", $httpMsg3->getHeaderLine("Content-Length"));
        $this->assertFalse($httpMsg->hasHeader("Content-Length"));
        $this->assertFalse($httpMsg1->hasHeader("Content-Length"));
        $this->assertFalse($httpMsg2->hasHeader("Content-Length"));
    }


    public function test_method_clone_with_added_header_fail()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();

        $fail = false;
        try {
            $httpMsg1 = $httpMsg->withAddedHeader("", "value3");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"name\" value. Must be a non empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_without_header()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();
        $this->assertSame(["value1", "value2"], $httpMsg->getHeader("Content-Type"));


        $httpMsg1 = $httpMsg->withAddedHeader("Content-Length", ["one", "two", "three"]);
        $this->assertSame("one, two, three", $httpMsg1->getHeaderLine("Content-Length"));
        $this->assertFalse($httpMsg->hasHeader("Content-Length"));


        $httpMsg2 = $httpMsg->withoutHeader("Content-Length");
        $this->assertFalse($httpMsg2->hasHeader("Content-Length"));
    }


    public function test_method_clone_without_header_fail()
    {
        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message();

        $fail = false;
        try {
            $httpMsg1 = $httpMsg->withoutHeader("", "value3");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid given \"name\" value. Must be a non empty string.", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_clone_with_body()
    {
        $oStream = provider_PHPStream_InstanceOf_Stream_FromText("Test stream object");
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $oHeaders = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);

        $httpMsg = provider_PHPHTTPMessage_InstanceOf_Message("1.1", $oHeaders, $oStream);
        $oStream1 = provider_PHPStream_InstanceOf_Stream_FromText("Another test stream object.");

        $this->assertSame($oStream, $httpMsg->getBody());
        $httpMsg1 = $httpMsg->withBody($oStream1);
        $this->assertSame($oStream1, $httpMsg1->getBody());
    }

}
