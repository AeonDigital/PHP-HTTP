<?php

declare(strict_types=1);

namespace AeonDigital\Http\Data;

use Psr\Http\Message\UploadedFileInterface as UploadedFileInterface;
use AeonDigital\Interfaces\Http\Data\iFile as iFile;
use AeonDigital\Interfaces\Stream\iFileStream as iFileStream;
use AeonDigital\BObject as BObject;




/**
 * Representa um arquivo sendo enviado por um ``UA``.
 *
 * Esta classe é compatível com a PSR ``Psr\Http\Message\UploadedFileInterface`` mas não a implementa
 * de forma direta. Use a classe ``PSRFile`` ou o método ``toPSR`` para obter uma instância
 * que implemente tal interface.
 *
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class File extends BObject implements iFile
{
    use \AeonDigital\Http\Traits\MimeTypeData;




    /**
     * Identifica quando o arquivo já foi removido do local original para o local final.
     *
     * @var bool
     */
    protected bool $isMoved = false;



    /**
     * Nome do arquivo conforme foi postado pelo ``UA``.
     *
     * @var string
     */
    protected string $clientFilename = "";










    /**
     * Stream do arquivo.
     *
     * @var iFileStream
     */
    protected iFileStream $fileStream;
    /**
     * Retorna o stream que representa o arquivo sendo enviado.
     *
     * @return iFileStream
     */
    public function getStream(): iFileStream
    {
        return $this->fileStream;
    }



    /**
     * Retorna o tamanho (em bytes) do ``Stream`` carregado.
     * Retornará ``null`` quando o stream for liberado usando o método ``dropStream``.
     *
     * @return ?int
     */
    public function getSize(): ?int
    {
        return $this->fileStream->getSize();
    }



    /**
     * Retorna o caminho completo para onde o arquivo está salvo no servidor.
     *
     * @return string
     */
    public function getPathToFile(): string
    {
        return $this->fileStream->getPathToFile();
    }



    /**
     * Retorna o nome do arquivo que está sendo enviado.
     *
     * @return string
     */
    public function getClientFilename(): string
    {
        return $this->clientFilename;
    }



    /**
     * Resgata o mimetype do arquivo que está sendo enviado.
     *
     * @return string
     */
    public function getClientMediaType(): string
    {
        if ($this->clientFilename !== $this->fileStream->getFilename()) {
            return $this->retrieveFileMimeType($this->clientFilename);
        } else {
            return $this->fileStream->getMimeType();
        }
    }





    /**
     * Libera o ``stream`` para que o recurso possa ser usado por outra tarefa.
     *
     * Após esta ação os métodos da instância que dependem diretamente do recurso que foi
     * liberado não irão funcionar.
     *
     * @return void
     */
    public function dropStream(): void
    {
        $this->fileStream->close();
    }










    /**
     * Código de erro ao efetuar o upload do arquivo.
     *
     * @var int
     */
    protected int $uploadError = \UPLOAD_ERR_OK;
    /**
     * Retorna o erro ao efetuar o upload do arquivo, se houver.
     * Não havendo erro o valor retornado é equivalente a constante ``UPLOAD_ERR_OK``
     *
     * @return int
     */
    public function getError(): int
    {
        return $this->uploadError;
    }










    /**
     * Identifica quando o ambiente atual pode ser identificado como sendo ``SAPI``.
     *
     * @return bool
     */
    protected function isSapi(): bool
    {
        return (\substr(\php_sapi_name(), 0, 3) == "cgi");
    }










    /**
     * Inicia um novo objeto ``File``.
     *
     * @param iFileStream $fileStream
     * Stream que representa o arquivo que está sendo enviado pelo ``UA``.
     *
     * @param ?string $clientFileName
     * Nome do arquivo conforme foi postado pelo ``UA``.
     * Se não for indicado, pegará o valor definido em ``$fileStream->getFilename()``.
     *
     * @param int $uploadError
     * Código de erro ao efetuar o upload, caso exista.
     *
     * @throws \InvalidArgumentException
     * Caso o arquivo indicado não exista.
     */
    function __construct(
        iFileStream $fileStream,
        ?string $clientFilename = null,
        int $uploadError = \UPLOAD_ERR_OK
    ) {
        $this->fileStream = $fileStream;
        $this->clientFilename = (string)$clientFilename;
        $this->uploadError = $uploadError;

        if ($this->clientFilename === "") {
            $this->clientFilename = $fileStream->getFilename();
        }
    }










    /**
     * Move o arquivo carregado para a nova localização.
     *
     * Esta ação só pode ser executada 1 vez pois o arquivo na posição original será excluido ao
     * final do processo.
     *
     * @param string $targetPath
     * Caminho completo até o novo local onde o arquivo deve ser salvo.
     *
     * @throws \InvalidArgumentException
     * Caso o destino especificado seja inválido
     *
     * @throws \RuntimeException
     * Quando alguma operação de mover ou excluir falhar.
     */
    public function moveTo(string $targetPath): void
    {
        $isStream = \strpos($targetPath, '://') > 0;
        if ($isStream === false && \is_writable(\dirname($targetPath)) === false) {
            throw new \InvalidArgumentException("Upload target path is not writable.");
        } else {
            $errMsg = null;
            $this->dropStream();


            if ($this->isMoved === true) {
                $errMsg = "Target uploaded file already moved.";
            } else {
                if ($isStream === true || $this->isSapi() === true) {
                    if (\copy($this->getPathToFile(), $targetPath) === false) {
                        $errMsg = "Can not move the uploaded file.";
                    }
                    if (\unlink($this->getPathToFile()) === false) {
                        $errMsg = "Can not remove uploaded file from original location.";
                    }
                } else {
                    if (\rename($this->getPathToFile(), $targetPath) === false) {
                        $errMsg = "Can not remove uploaded file from original location.";
                    }
                }
            }


            if ($errMsg !== null) {
                throw new \RuntimeException($errMsg);
            } else {
                $this->isMoved = true;
                $this->fileStream->setFileStream($targetPath);
            }
        }
    }





    /**
     * Retorna uma instância deste mesmo objeto, porém, compatível com a interface
     * original ``Psr\Http\Message\UploadedFileInterface``.
     */
    public function toPSR(): UploadedFileInterface
    {
        return new \AeonDigital\Http\Data\PSRFile(
            $this->getPathToFile(),
            $this->clientFilename,
            $this->uploadError
        );
    }
}
