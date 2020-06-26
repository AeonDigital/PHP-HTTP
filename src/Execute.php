<?php
declare (strict_types=1);

namespace AeonDigital\Http;

use AeonDigital\Interfaces\Http\iExecute as iExecute;








/**
 * Implementação de ``iExecute``.
 *
 * @package     AeonDigital\Http
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Execute implements iExecute
{





    /**
     * Efetua uma requisição ``Http``.
     * Qualquer tipo de falha encontrada fará retornar ``null``.
     *
     * @param       string $method
     *              Método ``Http`` que será executado.
     *
     * @param       string $absoluteURL
     *              ``URL`` alvo.
     *
     * @param       array $content
     *              Array associativo com as chaves e valores que serão enviados.
     *
     * @param       array $headers
     *              Array associativo com cabeçalhos ``Http`` para serem enviados na requisição.
     *
     * @return      ?string
     */
    public static function request(
        string $method,
        string $absoluteURL,
        array $content = [],
        array $headers = []
    ) : ?string {
        $r = null;
        $method = (($method === "") ? "GET" : \strtoupper($method));



        // Remove qualquer particula #hash da URL
        if (\mb_strpos($absoluteURL, "#") !== false) {
            $absoluteURL = \explode("#", $absoluteURL)[0];
        }



        // Se for um GET, converte todos os valores a serem enviados em
        // parametros de URL
        if ($method === "GET" && \count($content) > 0) {
            $urlParans = \http_build_query($content);

            $firstParan = ((\mb_strpos($absoluteURL, "?") !== false) ? "&" : "?");
            $absoluteURL .= $firstParan . $urlParans;
            $content = [];
        }



        // Prepara os dados que serão enviados
        $postContent = \http_build_query($content);


        // Uma requisição terá, inicialmente os seguintes headers
        $defaultHeaders = [
            "Connection"        => "close",
            "Content-type"      => "application/x-www-form-urlencoded",
            "Content-Length"    => \mb_strlen($postContent)
        ];


        // Une os headers padrão e os passados
        // substituindo os iniciais caso novos valores sejam passados.
        $finalHeaders = \array_merge($defaultHeaders, $headers);


        // Prepara os headers em formato de string para serem usados.
        $strHeaders = "";
        foreach ($finalHeaders as $h => $v) {
            $strHeaders .= $h . ": " . $v . "\r\n";
        }


        // Cria um objeto "stream" preparado com o conteúdo definido
        $streamResource = \stream_context_create([
            "http" => [
                "method"    => $method,
                "header"    => $strHeaders,
                "content"   => $postContent
            ]
        ]);


        $resultData = @\file_get_contents($absoluteURL, false, $streamResource);
        if ($resultData !== false) {
            $r = $resultData;
        }


        return $r;
    }





    /**
     * Efetua o download de um arquivo a partir de uma ``URL`` e salva-o no diretório indicado
     * com o nome escolhido.
     *
     * @param       string $absoluteURL
     *              ``URL`` de onde o arquivo será resgatado.
     *
     * @param       string $absoluteSystemPathToDir
     *              Diretório da aplicação onde o arquivo será salvo.
     *
     * @param       string $fileName
     *              Nome usado para salvar o arquivo.
     *              Se não informado será usado o nome original do mesmo.
     *
     * @return      bool
     */
    public static function download(
        string $absoluteURL,
        string $absoluteSystemPathToDir,
        string $fileName = ""
    ) : bool {

        $rBool = false;

        // Efetua o download do arquivo
        $downloadedFile = \fopen($absoluteURL, "rb");
        if ($downloadedFile !== false) {
            $originalExt = \pathinfo($absoluteURL, PATHINFO_EXTENSION);
            $originalFileName = \pathinfo($absoluteURL, PATHINFO_BASENAME);


            // Se não for definido o nome do arquivo... resgata o nome original
            $fileName = (($fileName === "") ? $originalFileName : $fileName);
            $fileNamelExt = \pathinfo($fileName, PATHINFO_EXTENSION);

            if (\strtolower($originalExt) !== \strtolower($fileNamelExt)) {
                $fileName = \str_replace("." . $fileNamelExt, "." . \strtolower($originalExt), $fileName);
            }


            // Corrige "/" no final do caminho
            $ds = DIRECTORY_SEPARATOR;
            $absoluteSystemPathToDir = \rtrim($absoluteSystemPathToDir, $ds) . $ds;

            // Abre/Cria o novo arquivo
            $newFile = \fopen($absoluteSystemPathToDir . $fileName, "ab+");
            if ($newFile !== false) {
                // Recria o conteúdo do arquivo
                while (\feof($downloadedFile) === false) {
                    \fwrite($newFile, \fread($downloadedFile, 1024 * 8), 1024 * 8);
                }

                // Encerra os arquivos abertos
                \fclose($downloadedFile);
                \fclose($newFile);

                $rBool = true;
            }
        }

        return $rBool;
    }
}
