<?php






function provider_PHPHTTPData_InstanceOf_Cookie(
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


function provider_PHPHTTPData_InstanceOf_Cookie_AutoSet()
{
    $exp = new \DateTime();
    $exp->add(new DateInterval('P1D'));

    return provider_PHPHTTPData_InstanceOf_Cookie(
        "name",
        "acentuação",
        $exp,
        "DOMAIN.COM",
        "path",
        true,
        true
    );
}


function provider_PHPHTTPData_InstanceOf_CookieCollection($cookies = null) {
    return new \AeonDigital\Http\Data\CookieCollection($cookies);
}


function provider_PHPHTTPData_InstanceOf_CookieCollection_AutoSet() {
    $ck1 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();
    $ck2 = provider_PHPHTTPData_InstanceOf_Cookie_AutoSet();

    $ck1->setName("cookie1");
    $ck2->setName("cookie2");

    $ck1->setValue("value 1");
    $ck2->setValue("value 2");

    return provider_PHPHTTPData_InstanceOf_CookieCollection(["ignoredName1" => $ck1, "ignoredName2" => $ck2]);
}


function provider_PHPHTTPData_InstanceOf_File(
    $fileStream,
    ?string $clientFilename = null,
    int $uploadError = UPLOAD_ERR_OK
) {
    return new \AeonDigital\Http\Data\File(
        $fileStream,
        $clientFilename,
        $uploadError
    );
}


function provider_PHPHTTPData_InstanceOf_File_FromFileName($fileName)
{
    $fileStream = provider_PHPStream_InstanceOf_FileStream($fileName);
    return provider_PHPHTTPData_InstanceOf_File($fileStream);
}


function provider_PHPHTTPData_InstanceOf_FileCollection($fileStreams = null)
{
    return new \AeonDigital\Http\Data\FileCollection($fileStreams);
}


function provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_01()
{
    return [
        "CONTENT_TYPE" => "value1, value2",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
    ];
}


function provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_02()
{
    return [
        "CONTENT_TYPE" => "value1, value2",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
        "unique" => "value unique"
    ];
}


function provider_PHPHTTPData_AssocArrayOf_HTTPHeaders_To_AbstractTest_03()
{
    return [
        "CONTENT_TYPE" => "ctype",
        "accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "accept-language" => "pt-BR, pt;q=0.8, en-US;q=0.5, en;q=0.3",
        "teste" => "text/html, application/xhtml+xml, application/xml;q=0.9 , */*;q=0.8",
    ];
}


function provider_PHPHTTPData_InstanceOf_HeaderCollection($headers = null)
{
    return new \AeonDigital\Http\Data\HeaderCollection($headers);
}


function provider_PHPHTTPData_AssocArrayOf_HTTPQueryStrings_To_AbstractTest_01()
{
    return [
        "qs1" => "acentuação e espaços",
        "qs2" => "value2",
        "qs3" => "value3",
        "qs4" => "value4",
        "QS4" => "value4.1%20and"
    ];
}


function provider_PHPHTTPData_InstanceOf_QueryStringCollection($queryStrings = null)
{
    return new \AeonDigital\Http\Data\QueryStringCollection($queryStrings);
}
