<?php





function provider_PHPHTTPMessage_InstanceOf_Message(
    $version = "1.1",
    $headerCollection = null,
    $stream = null
) {
    if ($headerCollection === null) {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $headerCollection = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);
    }

    if ($stream === null) {
        $stream = provider_PHPStream_InstanceOf_Stream_FromText();
    } else {
        if (is_string($stream) === true) {
            $stream = provider_PHPStream_InstanceOf_Stream_FromText($stream);
        }
    }

    return new \AeonDigital\Http\Message\Tests\Concrete\Message($version, $headerCollection, $stream);
}


function provider_PHPHTTPMessage_InstanceOf_Request(
    $httpMethod = "GET",
    $url = null,
    $httpVersion = "1.1",
    $headerCollection = null,
    $stream = null
) {

    if ($url === null) {
        $url = provider_PHPHTTPURI_InstanceOf_Url();
    } else {
        if (is_string($url) === true) {
            $url = provider_PHPHTTPURI_InstanceOf_Url($url);
        }
    }

    if ($headerCollection === null) {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $headerCollection = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);
    }

    if ($stream === null) {
        $stream = provider_PHPStream_InstanceOf_Stream_FromText();
    } else {
        if (is_string($stream) === true) {
            $stream = provider_PHPStream_InstanceOf_Stream_FromText($stream);
        }
    }

    return new \AeonDigital\Http\Message\Request(
        $httpMethod,
        $url,
        $httpVersion,
        $headerCollection,
        $stream
    );
}


function provider_PHPHTTPMessage_InstanceOf_Response(
    $statusCode = 200,
    $reasonPhrase = "",
    $httpVersion = "1.1",
    $headerCollection = null,
    $stream = null,
    $viewData = null,
    $viewConfig = null
) {

    if ($headerCollection === null) {
        $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01();
        $headerCollection = provider_PHPHTTPData_InstanceOf_HeaderCollection($headers);
    }

    if ($stream === null) {
        $stream = provider_PHPStream_InstanceOf_Stream_FromText();
    } else {
        if (is_string($stream) === true) {
            $stream = provider_PHPStream_InstanceOf_Stream_FromText($stream);
        }
    }

    return new \AeonDigital\Http\Message\Response(
        $statusCode,
        $reasonPhrase,
        $httpVersion,
        $headerCollection,
        $stream,
        $viewData,
        $viewConfig
    );
}


function provider_PHPHTTPMessage_InstanceOf_HeaderCollection($contentType = null)
{
    $headers = provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_03();
    if ($contentType === null) {
        $contentType = "application/json";
    }

    $headers["CONTENT_TYPE"] = $contentType;
    return new \AeonDigital\Http\Data\HeaderCollection($headers);
}


function provider_PHPHTTPMessage_InstanceOf_QueryStringCollection($useQS = null)
{
    if ($useQS === null) {
        $baseQS = provider_PHPHTTPData_AssocArrayOf_HTTPQueryStrings_To_AbstractTest_01();
        return new \AeonDigital\Http\Data\QueryStringCollection($baseQS);
    } else {
        if (is_array($useQS) === true) {
            return new \AeonDigital\Http\Data\QueryStringCollection($baseQS);
        }
        elseif (is_string($useQS) === true) {
            return \AeonDigital\Http\Data\QueryStringCollection::fromString($useQS);
        }
        else {
            return \AeonDigital\Http\Data\QueryStringCollection::fromString($useQS->getQuery());
        }
    }
}


function provider_PHPHTTPMessage_InstanceOf_FileCollection($fileNames = null)
{
    $r = [];
    $counter = 1;

    if (is_array($fileNames) === true) {
        foreach ($fileNames as $file) {
            $k = "file" . $counter;
            $r[$k] = provider_PHPHTTPData_InstanceOf_File_FromFileName($file);
            $counter++;
        }
    }

    return new \AeonDigital\Http\Data\FileCollection($r);
}


function provider_PHPHTTPMessage_AssocArrayOf_ServerParans_To_AbstractTest_01()
{
    return [
        "param1" => "paramValue1",
        "param2" => "paramValue2",
        "param3" => "paramValue3",
        "param4" => "paramValue4",
    ];
}


function provider_PHPHTTPMessage_InstanceOf_Collection_Empty_To_AbstractTest_01()
{
    return new \AeonDigital\Collection\Collection();
}

function provider_PHPHTTPMessage_InstanceOf_Collection_Attributes_To_AbstractTest_01()
{
    return new \AeonDigital\Collection\Collection(["attribute1" => "value1", "attribute2" => "value2"]);
}


function provider_PHPHTTPMessage_InstanceOf_Collection_BodyParsers_To_AbstractTest_01()
{
    $bodyParsers =  new \AeonDigital\Collection\Collection();
    $bodyParsers->set("application/json", function (string $strBody) {
        return json_decode($strBody, true);
    });
    return $bodyParsers;
}


function provider_PHPHTTPMessage_InstanceOf_CookieCollection_AutoSet()
{
    $ck1 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
    $ck2 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
    $ck3 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
    $ck4 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
    $ck5 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();

    $ck1->setName("cookie1");
    $ck2->setName("cookie2");
    $ck3->setName("field3");
    $ck4->setName("_mime");
    $ck5->setName("_locale");


    $ck1->setValue("value 1");
    $ck2->setValue("value 2");
    $ck3->setValue("not overwrited cookie");
    $ck4->setValue("html");
    $ck5->setValue("pt-BR");

    return provider_PHPHTTPData_InstanceOf_CookieCollection([$ck1, $ck2, $ck3, $ck4, $ck5]);
}


function provider_PHPHTTPMessage_InstanceOf_ServerRequest_01(
    $method = "GET",
    $url = null,
    $body = null,
    $contentType = null,
    $withBodyParser = false
) {

    $oUri           = provider_PHPHTTPURI_InstanceOf_Url($url);
    $oHeaders       = provider_PHPHTTPMessage_InstanceOf_HeaderCollection($contentType);
    $oBody          = provider_PHPStream_InstanceOf_Stream_FromText($body);
    $oCookies       = provider_PHPHTTPData_InstanceOf_CookieCollection_AutoSet();
    $oQuery         = provider_PHPHTTPMessage_InstanceOf_QueryStringCollection($oUri);
    $oFiles         = provider_PHPHTTPMessage_InstanceOf_FileCollection(["upload-image-1.jpg", "upload-image-2.jpg"]);
    $oServerParans  = provider_PHPHTTPMessage_AssocArrayOf_ServerParans_To_AbstractTest_01();
    $oAttr          = provider_PHPHTTPMessage_InstanceOf_Collection_Attributes_To_AbstractTest_01();
    $oParsers       = (($withBodyParser === true) ? provider_PHPHTTPMessage_InstanceOf_Collection_BodyParsers_To_AbstractTest_01() : null);

    return new \AeonDigital\Http\Message\ServerRequest(
        $method,
        $oUri,
        "1.1",
        $oHeaders,
        $oBody,
        $oCookies,
        $oQuery,
        $oFiles,
        $oServerParans,
        $oAttr,
        $oParsers
    );
}


function provider_PHPHTTPMessage_InstanceOf_ServerRequest_02(
    $method = "GET",
    $url = null,
    $body = null,
    $contentType = null,
    $withBodyParser = false
) {

    $oUri           = provider_PHPHTTPURI_InstanceOf_Url($url);
    $oHeaders       = provider_PHPHTTPMessage_InstanceOf_HeaderCollection($contentType);
    $oBody          = provider_PHPStream_InstanceOf_Stream_FromText($body);
    $oCookies       = provider_PHPHTTPMessage_InstanceOf_CookieCollection_AutoSet();
    $oQuery         = provider_PHPHTTPMessage_InstanceOf_QueryStringCollection($oUri);
    $oFiles         = provider_PHPHTTPMessage_InstanceOf_FileCollection();
    $oServerParans  = [];
    $oAttr          = provider_PHPHTTPMessage_InstanceOf_Collection_Empty_To_AbstractTest_01();
    $oParsers       = (($withBodyParser === true) ? provider_PHPHTTPMessage_InstanceOf_Collection_BodyParsers_To_AbstractTest_01() : null);


    return new \AeonDigital\Http\Message\ServerRequest(
        $method,
        $oUri,
        "1.1",
        $oHeaders,
        $oBody,
        $oCookies,
        $oQuery,
        $oFiles,
        $oServerParans,
        $oAttr,
        $oParsers
    );
}
