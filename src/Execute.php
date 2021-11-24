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
     * Armazena o status de erro ocorrido após a última requisição.
     * O Valor vazio "" indica que nenhum erro ocorreu.
     *
     * @var         string
     */
    private static string $lastRequestError = "";
    /**
     * Retorna o status do último erro ocorrido após o a última requisição executada.
     * O Valor vazio "" indica que nenhum erro ocorreu.
     *
     * @return      string
     */
    public static function getLastError() : string
    {
        return self::$lastRequestError;
    }





    /**
     * Efetua uma requisição ``Http`` e retorna uma string correspondente
     * ao conteúdo da URL que foi requisitada.
     * 
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
     * @param       ?string $absolutePathToUploadFile
     *              Caminho absoluto até um arquivo que se deseja efetuar o upload.
     *
     * @return      ?string
     */
    protected static function mainRequest(
        string $method,
        string $absoluteURL,
        array $content = [],
        array $headers = [],
        ?string $absolutePathToUploadFile = null
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



        // Prepara e executa a requisição usando 'curl'
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $absoluteURL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        if ($method !== "GET") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            if (count($content) > 0) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            }

            if ($absolutePathToUploadFile !== null) {
                curl_setopt($curl, CURLOPT_PUT, true);
                curl_setopt($curl, CURLOPT_INFILE, fopen($absolutePathToUploadFile, "r"));
            }
        }

        $responseData = curl_exec($curl);
        self::$lastRequestError = curl_error($curl);
        curl_close($curl);


        if (self::$lastRequestError === "") {
            $r = $responseData;
        }


        return $r;
    }




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
        return self::mainRequest($method, $absoluteURL, $content, $headers);
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
        $downloadedFile = self::mainRequest("GET", $absoluteURL);
        if ($downloadedFile !== null) {
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
            $r = file_put_contents($absoluteSystemPathToDir . $fileName, $downloadedFile);
            $rBool = (($r === false) ? false : true);
        }

        return $rBool;
    }
}
