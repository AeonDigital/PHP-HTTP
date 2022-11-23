<?php



// ---
// Objetos e processos de uso variado.

function prov_assocArray_to_Http_Header_01()
{
    return [
        "CONTENT_TYPE" => "value1, value2",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
    ];
}
function prov_assocArray_to_Http_Header_02()
{
    return [
        "CONTENT_TYPE" => "value1, value2",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
        "unique" => "value unique"
    ];
}
function prov_assocArray_to_Http_Header_03()
{
    return [
        "CONTENT_TYPE" => "ctype",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "accept-language" => "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
    ];
}
function prov_assocArray_to_Http_QueryString_01()
{
    return [
        "qs1" => "acentuação e espaços",
        "qs2" => "value2",
        "qs3" => "value3",
        "qs4" => "value4",
        "QS4" => "value4.1%20and"
    ];
}






// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_Http_Cookie(
    string $name,
    string $value = "",
    ?\DateTime $expires = null,
    ?string $domain = null,
    string $path = "/",
    bool $secure = false,
    bool $httpOnly = false
) {
    return new \AeonDigital\Http\Data\Cookie(
        $name,
        $value,
        $expires,
        $domain,
        $path,
        $secure,
        $httpOnly
    );
}
function prov_instanceOf_Http_Cookie_autoset()
{
    $exp = new \DateTime();
    $exp->add(new DateInterval('P1D'));

    return prov_instanceOf_Http_Cookie(
        "name",
        "acentuação",
        $exp,
        "DOMAIN.COM",
        "path",
        true,
        true
    );
}



function prov_instanceOf_Http_CookieCollection($cookies = null)
{
    return new \AeonDigital\Http\Data\CookieCollection($cookies);
}
function prov_instanceOf_Http_CookieCollection_autoSet_01()
{
    $ck1 = prov_instanceOf_Http_Cookie_autoset();
    $ck2 = prov_instanceOf_Http_Cookie_autoset();

    $ck1->setName("cookie1");
    $ck2->setName("cookie2");

    $ck1->setValue("value 1");
    $ck2->setValue("value 2");

    return prov_instanceOf_Http_CookieCollection(["ignoredName1" => $ck1, "ignoredName2" => $ck2]);
}
function prov_instanceOf_Http_CookieCollection_autoSet_02()
{
    $ck1 = prov_instanceOf_Http_Cookie_autoset();
    $ck2 = prov_instanceOf_Http_Cookie_autoset();
    $ck3 = prov_instanceOf_Http_Cookie_autoset();
    $ck4 = prov_instanceOf_Http_Cookie_autoset();
    $ck5 = prov_instanceOf_Http_Cookie_autoset();

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

    return prov_instanceOf_Http_CookieCollection([$ck1, $ck2, $ck3, $ck4, $ck5]);
}




function prov_instanceOf_Http_UploadedFile(
    $fileStream,
    ?string $clientFilename = null,
    int $uploadError = UPLOAD_ERR_OK
) {
    return new \AeonDigital\Http\Data\UploadedFile(
        $fileStream,
        $clientFilename,
        $uploadError
    );
}
function prov_instanceOf_Http_File_fromFileName($fileName)
{
    $fileStream = prov_instanceOf_Http_FileStream_fromFile($fileName);
    return prov_instanceOf_Http_UploadedFile($fileStream);
}



function prov_instanceOf_Http_UploadedFileCollection_01($fileStreams = null)
{
    return new \AeonDigital\Http\Data\UploadedFileCollection($fileStreams);
}
function prov_instanceOf_Http_UploadedFileCollection_02($fileNames = null)
{
    $r = [];
    $counter = 1;

    if (is_array($fileNames) === true) {
        foreach ($fileNames as $file) {
            $k = "file" . $counter;
            $r[$k] = prov_instanceOf_Http_File_fromFileName($file);
            $counter++;
        }
    }

    return new \AeonDigital\Http\Data\UploadedFileCollection($r);
}



function prov_instanceOf_Http_HeaderCollection_01($headers = null)
{
    return new \AeonDigital\Http\Data\HeaderCollection($headers);
}
function prov_instanceOf_Http_HeaderCollection_02($contentType = null)
{
    $headers = prov_assocArray_to_Http_Header_03();
    if ($contentType === null) {
        $contentType = "application/json";
    }

    $headers["CONTENT_TYPE"] = $contentType;
    return new \AeonDigital\Http\Data\HeaderCollection($headers);
}



function prov_instanceOf_Http_QueryStringCollection_01($queryStrings = null)
{
    return new \AeonDigital\Http\Data\QueryStringCollection($queryStrings);
}
function prov_instanceOf_Http_QueryStringCollection_02($useQS = null)
{
    if ($useQS === null) {
        $baseQS = prov_assocArray_to_Http_QueryString_01();
        return new \AeonDigital\Http\Data\QueryStringCollection($baseQS);
    } else {
        if (is_array($useQS) === true) {
            return new \AeonDigital\Http\Data\QueryStringCollection($useQS);
        }
        elseif (is_string($useQS) === true) {
            return \AeonDigital\Http\Data\QueryStringCollection::fromString($useQS);
        }
        else {
            return \AeonDigital\Http\Data\QueryStringCollection::fromString($useQS->getQuery());
        }
    }
}
