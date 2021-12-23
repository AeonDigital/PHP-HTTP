<?php



// ---
// Objetos e processos de uso variado.

function prov_assocArray_to_Http_ServerRequest()
{
    return [
        "param1" => "paramValue1",
        "param2" => "paramValue2",
        "param3" => "paramValue3",
        "param4" => "paramValue4",
    ];
}
function prov_instanceOf_Collection_Collection_01()
{
    return new \AeonDigital\Collection\Collection();
}
function prov_instanceOf_Collection_Collection_02()
{
    return new \AeonDigital\Collection\Collection(["attribute1" => "value1", "attribute2" => "value2"]);
}
function prov_instanceOf_Collection_Collection_03()
{
    $bodyParsers =  new \AeonDigital\Collection\Collection();
    $bodyParsers->set("application/json", function (string $strBody) {
        return json_decode($strBody, true);
    });
    return $bodyParsers;
}





// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_Http_Message(
    $version = "1.1",
    $headerCollection = null,
    $stream = null
) {
    if ($headerCollection === null) {
        $headers = prov_assocArray_to_Http_Header_01();
        $headerCollection = prov_instanceOf_Http_HeaderCollection_01($headers);
    }

    if ($stream === null) {
        $stream = prov_instanceOf_Http_Stream_fromString();
    } else {
        if (is_string($stream) === true) {
            $stream = prov_instanceOf_Http_Stream_fromString($stream);
        }
    }

    return new \AeonDigital\Http\Message\Tests\Concrete\Message($version, $headerCollection, $stream);
}



function prov_instanceOf_Http_Request(
    $httpMethod = "GET",
    $url = null,
    $httpVersion = "1.1",
    $headerCollection = null,
    $stream = null
) {

    if ($url === null) {
        $url = prov_instanceOf_Http_Url_fromString();
    } else {
        if (is_string($url) === true) {
            $url = prov_instanceOf_Http_Url_fromString($url);
        }
    }

    if ($headerCollection === null) {
        $headers = prov_assocArray_to_Http_Header_01();
        $headerCollection = prov_instanceOf_Http_HeaderCollection_01($headers);
    }

    if ($stream === null) {
        $stream = prov_instanceOf_Http_Stream_fromString();
    } else {
        if (is_string($stream) === true) {
            $stream = prov_instanceOf_Http_Stream_fromString($stream);
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



function prov_instanceOf_Http_Response(
    $statusCode = 200,
    $reasonPhrase = "",
    $httpVersion = "1.1",
    $headerCollection = null,
    $stream = null,
    $viewData = null,
    $viewConfig = null
) {

    if ($headerCollection === null) {
        $headers = prov_assocArray_to_Http_Header_01();
        $headerCollection = prov_instanceOf_Http_HeaderCollection_01($headers);
    }

    if ($stream === null) {
        $stream = prov_instanceOf_Http_Stream_fromString();
    } else {
        if (is_string($stream) === true) {
            $stream = prov_instanceOf_Http_Stream_fromString($stream);
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



function prov_instanceOf_Http_ServerRequest_01(
    $method = "GET",
    $url = null,
    $body = null,
    $contentType = null,
    $withBodyParser = false
) {

    $oUri           = prov_instanceOf_Http_Url_fromString($url);
    $oHeaders       = prov_instanceOf_Http_HeaderCollection_02($contentType);
    $oBody          = prov_instanceOf_Http_Stream_fromString($body);
    $oCookies       = prov_instanceOf_Http_CookieCollection_autoSet_01();
    $oQuery         = prov_instanceOf_Http_QueryStringCollection_02($oUri);
    $oFiles         = prov_instanceOf_Http_FileCollection_02(["upload-image-1.jpg", "upload-image-2.jpg"]);
    $oServerParans  = prov_assocArray_to_Http_ServerRequest();
    $oAttr          = prov_instanceOf_Collection_Collection_02();
    $oParsers       = (($withBodyParser === true) ? prov_instanceOf_Collection_Collection_03() : null);

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


function prov_instanceOf_Http_ServerRequest_02(
    $method = "GET",
    $url = null,
    $body = null,
    $contentType = null,
    $withBodyParser = false
) {

    $oUri           = prov_instanceOf_Http_Url_fromString($url);
    $oHeaders       = prov_instanceOf_Http_HeaderCollection_02($contentType);
    $oBody          = prov_instanceOf_Http_Stream_fromString($body);
    $oCookies       = prov_instanceOf_Http_CookieCollection_autoSet_02();
    $oQuery         = prov_instanceOf_Http_QueryStringCollection_02($oUri);
    $oFiles         = prov_instanceOf_Http_FileCollection_02();
    $oServerParans  = [];
    $oAttr          = prov_instanceOf_Collection_Collection_01();
    $oParsers       = (($withBodyParser === true) ? prov_instanceOf_Collection_Collection_03() : null);


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
