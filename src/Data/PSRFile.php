<?php

declare(strict_types=1);

namespace AeonDigital\Http\Data;

use Psr\Http\Message\UploadedFileInterface as UploadedFileInterface;
use Psr\Http\Message\StreamInterface as StreamInterface;
use AeonDigital\Interfaces\Stream\iFileStream as iFileStream;
use AeonDigital\BObject as BObject;




/**
 * Representa um arquivo sendo enviado por um ``UA``.
 *
 * Esta classe implementa a interface ``Psr\Http\Message\UploadedFileInterface``.
 *
 * @package     AeonDigital\Http\Data
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 *
 * @codeCoverageIgnore
 */
class PSRFile extends BObject implements UploadedFileInterface
{





    /**
     * Objeto principal.
     *
     * @var AeonDigital\Http\Data\File
     */
    private \AeonDigital\Http\Data\File $file;



    /**
     * Inicia um novo objeto ``File``.
     *
     * @param string $absolutePathToFile
     * Caminho completo até o arquivo alvo.
     * Obrigatorio se o objeto ``$fileStream`` for do tipo ``StreamInterface``.
     *
     * @param string $clientFileName
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
        string $absolutePathToFile,
        string $clientFilename = "",
        int $uploadError = \UPLOAD_ERR_OK
    ) {
        $this->file = new \AeonDigital\Http\Data\File(
            new \AeonDigital\Http\Stream\FileStream($absolutePathToFile),
            $clientFilename,
            $uploadError
        );
    }








    /**
     * Retorna o stream que representa o arquivo sendo enviado.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return new \AeonDigital\Http\Stream\PSRStream(
            \fopen($this->file->getPathToFile(), "r")
        );
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
    public function moveTo($targetPath)
    {
        $this->file->moveTo($targetPath);
    }

    /**
     * Retorna o tamanho (em bytes) do ``Stream`` carregado.
     * Retornará ``null`` quando o stream for liberado usando o método ``dropStream``.
     *
     * @return ?int
     */
    public function getSize()
    {
        return $this->file->getSize();
    }

    /**
     * Retorna o erro ao efetuar o upload do arquivo, se houver.
     * Não havendo erro o valor retornado é equivalente a constante ``UPLOAD_ERR_OK``
     *
     * @return int
     */
    public function getError()
    {
        return $this->file->getError();
    }

    /**
     * Retorna o nome do arquivo que está sendo enviado.
     *
     * @return ?string
     */
    public function getClientFilename()
    {
        return $this->file->getClientFilename();
    }

    /**
     * Resgata o mimetype do arquivo que está sendo enviado.
     *
     * @return ?string
     */
    public function getClientMediaType()
    {
        return $this->file->getClientMediaType();
    }
}
