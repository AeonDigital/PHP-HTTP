<?php



// ---
// Objetos e processos de uso variado.

function prov_copyFile_To_Http_Stream($originalFile, $copyTo)
{
    global $dirFiles;
    $oFile  = to_system_path($dirFiles . "/" . $originalFile);
    $cFile  = to_system_path($dirFiles . "/" . $copyTo);
    copy($oFile, $cFile);
}



function prov_instanceOf_PHPStream_fromString($body = "")
{
    return fopen("data://text/plain;base64," . base64_encode($body), "r+");
}
function prov_instanceOf_PHPStream_fromFile(
    $fileName,
    $openType = "rw",
    &$stats = null,
    &$meta = null
) {
    global $dirFiles;
    $useFilePath = to_system_path($dirFiles . "/" . $fileName);

    $r = null;
    if (file_exists($useFilePath)) {
        $r = fopen($useFilePath, $openType);
        $stats = fstat($r);
        $meta = stream_get_meta_data($r);
    }

    return $r;
}





// ---
// Geração de Instâncias de objetos.

function prov_instanceOf_Http_Stream_from_PHPStream($streamObject = null)
{
    if ($streamObject === null) {
        $streamObject = prov_instanceOf_PHPStream_fromString();
    }
    return new \AeonDigital\Http\Stream\Stream($streamObject);
}
function prov_instanceOf_Http_Stream_fromString($body = "")
{
    $streamObject = prov_instanceOf_PHPStream_fromString($body);
    return new \AeonDigital\Http\Stream\Stream($streamObject);
}



function prov_instanceOf_Http_FileStream_fromFile($fileName)
{
    global $dirFiles;
    $oFile  = to_system_path($dirFiles . "/" . $fileName);
    return new \AeonDigital\Http\Stream\FileStream($oFile);
}
