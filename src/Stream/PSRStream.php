<?php

declare(strict_types=1);

namespace AeonDigital\Http\Stream;

use Psr\Http\Message\StreamInterface as StreamInterface;
use AeonDigital\BObject as BObject;






/**
 * Fornece as operações básicas para o tratamento de Stream (fluxo) de dados.
 *
 * Esta classe implementa a interface ``Psr\Http\Message\StreamInterface``.
 *
 * ``Streams`` podem ser arquivos de qualquer natureza, um buffer ou mesmo um espaço na memória.
 *
 * Em PHP, geralmente os ``Streams`` são iniciados usando o comando ``fopen`` e é importante
 * lembrar que o modo com o qual o recurso foi aberto influencia a capacidade desta classe.
 *
 *
 * @see http://www.php-fig.org/psr/
 * @see http://php.net/manual/pt_BR/function.fopen.php
 *
 * @package     AeonDigital\Http\Stream
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 *
 * @codeCoverageIgnore
 */
class PSRStream extends BObject implements StreamInterface
{





    /**
     * Objeto principal.
     *
     * @var AeonDigital\Http\Stream\Stream
     */
    private \AeonDigital\Http\Stream\Stream $stream;



    /**
     * Inicia um manipulador de ``Stream``.
     *
     * @param resource $stream
     * Objeto ``Stream`` que será manipulado.
     *
     * @throws \InvalidArgumentException
     */
    function __construct($stream)
    {
        $this->stream = new \AeonDigital\Http\Stream\Stream($stream);
    }





    /**
     * Retorna os metadados do stream como um array associativo ou o valor específico de
     * uma chave indicada.
     *
     * Os dados retornados são identicos aos que seriam pegos pela função do PHP
     * ``stream_get_meta_data``.
     *
     * @link http://php.net/manual/en/function.stream-get-meta-data.php
     *
     * @param ?string $key
     * Nome da chave de metadados que serão retornados.
     *
     * @return null|array|mixed
     * Retorna ``null`` se o stream principal não estiver definido.
     *
     * Retorna um array associativo com todos valores atualmente definidos quando
     * a chave não for passada, ou, se for passada como ``null`` ou se for passada
     * como um valor que não seja uma ``string``.
     *
     * Retorna o valor atual da chave se ela existir.
     *
     * Retorna ``null`` se a chave não for encontrada.
     */
    public function getMetadata($key = null)
    {
        return $this->stream->getMetadata($key);
    }



    /**
     * Retorna ``true`` se o ``Stream`` carregado é *pesquisável*.
     *
     * @return bool
     */
    public function isSeekable()
    {
        return $this->stream->isSeekable();
    }



    /**
     * Retorna ``true`` se é possível escrever no ``Stream`` ou se ele está com seu modo de
     * escrita ativo.
     *
     * @return bool
     */
    public function isWritable()
    {
        return $this->stream->isWritable();
    }



    /**
     * Retorna ``true`` se é possível ler o ``Stream`` ou se ele está com seu modo de
     * leitura ativo.
     *
     * @return bool
     */
    public function isReadable()
    {
        return $this->stream->isReadable();
    }



    /**
     * Retorna o tamanho (em bytes) do ``Stream`` carregado ou ``null`` caso ele não exista ou se
     * não for possível determinar.
     *
     * @return ?int
     */
    public function getSize()
    {
        return $this->stream->getSize();
    }



    /**
     * Retornará ``true`` caso o ponteiro do ``Stream`` esteja posicionado no final do arquivo.
     *
     * @return bool
     */
    public function eof()
    {
        return $this->stream->eof();
    }



    /**
     * Retorna a posição atual do ponteiro.
     *
     * @return int
     *
     * @throws \RuntimeException
     */
    public function tell()
    {
        return $this->stream->tell();
    }



    /**
     * Modifica a posição do cursor dentro do ``Stream`` conforme indicações ``offset`` e
     * ``whence``.
     *
     * Esta função tem funcionamento identico ao ``fseek`` do PHP.
     * Importante lembrar que conforme o modo de abertura do recurso (r ; rw; r+; a+ ...) esta
     * função pode não funcionar adequadamente.
     *
     * @link http://www.php.net/manual/en/function.fseek.php
     *
     * @param int $offset
     * Posição que será definida para o cursor.
     *
     * @param int $whence
     * Especifica a forma como a posição do cursor será calculado.
     * Valores válidos são ``SEEK_SET``, ``SEEK_CUR`` e ``SEEK_END``.
     *
     * @throws \RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        $this->stream->seek($offset, $whence);
    }



    /**
     * Posiciona o cursor do ``Stream`` no início do mesmo.
     * Se o ``Stream`` não for *pesquisável* então este método irá lançar uma exception.
     *
     * @see seek()
     *
     * @link http://www.php.net/manual/en/function.fseek.php
     *
     * @throws \RuntimeException
     */
    public function rewind(): void
    {
        $this->stream->rewind();
    }



    /**
     * Lê as informações do ``Stream`` carregado a partir da posição atual do cursor até onde
     * ``$length`` indicar.
     *
     * @param int $length
     * Tamanho da string que será retornada.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function read($length)
    {
        return $this->stream->read($length);
    }



    /**
     * Escreve no ``Stream`` carregado.
     * Retorna o número de bytes escritos no ``Stream``.
     *
     * @param string $string
     * Dados que serão escritos.
     *
     * @return int
     *
     * @throws \RuntimeException
     */
    public function write($string)
    {
        return $this->stream->write($string);
    }



    /**
     * A partir da posição atual do cursor, retorna o conteúdo do ``Stream`` em uma string.
     * Lança uma exception caso algum erro ocorra.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getContents()
    {
        return $this->stream->getContents();
    }



    /**
     * Encerra o uso do ``Stream`` atualmente carregado para esta instância.
     * Retorna o objeto ``Stream`` em sua condição atual ou ``null`` caso ele não esteja definido.
     *
     * @return ?resource
     */
    public function detach()
    {
        return $this->stream->detach();
    }



    /**
     * Encerra o ``Stream``.
     *
     * @return void
     */
    public function close()
    {
        return $this->stream->close();
    }



    /**
     * Este método retorna todo o conteúdo do ``Stream`` em uma string.
     * Para isso, primeiro o cursor é reposicionado no início do mesmo e então seu conteúdo é
     * retornado.
     *
     * Ao final do processo, se possível (conforme o modo no qual o arquivo está aberto) o cursor
     * será reposicionado onde estava imediatamente antes da execução deste método. Este
     * comportamento é próprio desta implementação.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->stream;
    }
}
