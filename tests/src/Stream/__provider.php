<?php








if (function_exists("to_system_path") === false) {
    /**
     * Corrige um caminho para um diretório ou arquivo interno ajustando os separadores de
     * diretório e eliminando duplicação dos mesmos. Qualquer ``\\`` ou ``/`` no final do caminho
     * será removida.
     *
     * @param       ?string $systemPath
     *              Caminho que será ajustado.
     *
     * @return      ?string
     *              Caminho corrigido.
     */
    function to_system_path(?string $systemPath) : ?string
    {
        if ($systemPath === null) {
            return null;
        } else {
            $DS = DIRECTORY_SEPARATOR;
            $wrong = ($DS === "/") ? "\\" : "/";

            // Substitui separadores errados
            $systemPath = \str_replace($wrong, $DS, $systemPath);

            // Remove duplicação dos separadores
            while (\mb_strpos($systemPath, $DS . $DS) !== false) {
                $systemPath = \str_replace($DS . $DS, $DS, $systemPath);
            }

            return \rtrim($systemPath, $DS);
        }
    }
}




function provider_copyFile($originalFile, $copyTo)
{
    global $tstFileDir;
    $oFile  = to_system_path($tstFileDir . "/" . $originalFile);
    $cFile  = to_system_path($tstFileDir . "/" . $copyTo);
    copy($oFile, $cFile);
}


function provider_PHPStream_ObjectStreamFromText($body = "")
{
    return fopen("data://text/plain;base64," . base64_encode($body), "r+");
}


function provider_PHPStream_ObjectStreamFromFile(
    $fileName,
    $openType = "rw",
    &$stats = null,
    &$meta = null
) {
    global $tstFileDir;
    $useFilePath = to_system_path($tstFileDir . "/" . $fileName);

    $r = null;
    if (file_exists($useFilePath)) {
        $r = fopen($useFilePath, $openType);
        $stats = fstat($r);
        $meta = stream_get_meta_data($r);
    }

    return $r;
}


function provider_PHPStream_InstanceOf_Stream($streamObject = null)
{
    if ($streamObject === null) {
        $streamObject = provider_PHPStream_ObjectStreamFromText();
    }
    return new \AeonDigital\Http\Stream\Stream($streamObject);
}


function provider_PHPStream_InstanceOf_Stream_FromText($body = "")
{
    $streamObject = provider_PHPStream_ObjectStreamFromText($body);
    return new \AeonDigital\Http\Stream\Stream($streamObject);
}


function provider_PHPStream_InstanceOf_FileStream($fileName)
{
    global $tstFileDir;
    $oFile  = to_system_path($tstFileDir . "/" . $fileName);
    return new \AeonDigital\Http\Stream\FileStream($oFile);
}
