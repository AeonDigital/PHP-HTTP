<?php
declare (strict_types=1);

namespace AeonDigital\Http\Stream;

use AeonDigital\Interfaces\Stream\iFileStream as iFileStream;
use AeonDigital\Http\Stream\Stream as Stream;







/**
 * Extende a classe ``Stream`` para especializar-se em representar um arquivo físico e existente
 * no servidor atual.
 *
 * @package     AeonDigital\Http\Stream
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class FileStream extends Stream implements iFileStream
{
    use \AeonDigital\Http\Traits\MimeTypeData;



    /**
     * Modo de abertura do stream atual.
     *
     * @var         string
     */
    protected $openMode = "";





    /**
     * Caminho completo até onde o arquivo está armazenado no momento.
     *
     * @var         string
     */
    protected $pathToFile = null;
    /**
     * Retorna o caminho completo até onde o arquivo está no momento.
     *
     * @return      string
     */
    public function getPathToFile() : string
    {
        return $this->pathToFile;
    }





    /**
     * Nome do arquivo.
     *
     * @var         string
     */
    protected $fileName = null;
    /**
     * Retorna o nome do arquivo.
     *
     * @return      string
     */
    public function getFilename() : string
    {
        return $this->fileName;
    }





    /**
     * Mimetype do arquivo.
     *
     * @var         string
     */
    protected $mimeType = null;
    /**
     * Resgata o mimetype do arquivo.
     *
     * @return      string
     */
    public function getMimeType() : string
    {
        return $this->mimeType;
    }










    /**
     * Inicia um novo manipulador ``FileStream``.
     *
     *
     * @param       string $pathToFile
     *              Caminho completo até o arquivo alvo.
     *
     * @param       string $openMode
     *              Modo de abertura do stream.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o arquivo indicado não exista.
     */
    function __construct(string $pathToFile, string $openMode = "r")
    {
        $this->internalSetStream($pathToFile, $openMode);
    }



    /**
     * Define um novo arquivo alvo para a instância ``FileStream``.
     * Use o método ``detach`` para liberar o recurso atual para outras ações.
     *
     * @param       string $pathToFile
     *              Caminho completo até o arquivo alvo.
     *
     * @param       ?string $openMode
     *              Modo de abertura do stream.
     *              Se for mantido ``null``, o novo arquivo deve utilizar o mesmo modo usado
     *              pelo anterior.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o arquivo indicado não exista.
     */
    public function setFileStream(string $pathToFile, ?string $openMode = null) : void
    {
        $useMode = (($openMode === null) ? $this->openMode : $openMode);
        $this->internalSetStream($pathToFile, $useMode);
    }



    /**
     * Define o arquivo alvo para a instância ``FileStream``.
     *
     *
     * @param       string $pathToFile
     *              Caminho completo até o arquivo alvo.
     *
     * @param       string $openMode
     *              Modo de abertura do stream.
     *
     * @return      void
     *
     * @throws      \InvalidArgumentException
     *              Caso o arquivo indicado não exista.
     */
    protected function internalSetStream(string $pathToFile, string $openMode = "r") : void
    {
        $pathToFile = $this->normalizePathToFile($pathToFile);

        if (\file_exists($pathToFile) === false) {
            throw new \InvalidArgumentException("The target file does not exists [ \"" . $pathToFile . "\" ].");
        }

        parent::__construct(\fopen($pathToFile, $openMode));

        $this->openMode = $openMode;
        $this->pathToFile = $pathToFile;
        $this->fileName = \basename($pathToFile);
        $this->mimeType = $this->retrieveFileMimeType($pathToFile);
    }










    /**
     * Normaliza o caminho até o arquivo substituindo qualquer separador de diretório que esteja
     * em desacordo com o padrão para o S/O do ambiente atual e retorna seu valor corrigido.
     *
     * @param       string $pathToFile
     *              Caminho que será corrigido.
     *
     * @return      string
     */
    protected function normalizePathToFile(string $pathToFile) : string
    {
        $ds = DIRECTORY_SEPARATOR;
        $wrong = ($ds == "/") ? "\\" : "/";

        // Substitui separadores errados
        $pathToFile = \str_replace($wrong, $ds, $pathToFile);

        // Remove duplicação dos separadores
        while (\mb_strpos($pathToFile, $ds . $ds) !== false) {
            $pathToFile = \str_replace($ds . $ds, $ds, $pathToFile);
        }

        return \rtrim($pathToFile, $ds);
    }
}
