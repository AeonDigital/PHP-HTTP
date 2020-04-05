<?php
declare (strict_types=1);

namespace AeonDigital\Http\Stream;

use AeonDigital\Interfaces\Stream\iStream as iStream;








/**
 * Fornece as operações básicas para o tratamento de Stream (fluxo) de dados.
 *
 * ``Streams`` podem ser arquivos de qualquer natureza, um buffer ou mesmo um espaço na memória.
 *
 * Em PHP, geralmente os ``Streams`` são iniciados usando o comando ``fopen`` e é importante
 * lembrar que o modo com o qual o recurso foi aberto influencia a capacidade desta classe.
 *
 * Esta classe implementa a interface
 * ``Psr\Http\Message\StreamInterface`` através da interface ``iStream``.
 *
 * @see         http://www.php-fig.org/psr/
 * @see         http://php.net/manual/pt_BR/function.fopen.php
 *
 * @package     AeonDigital\Http\Stream
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   2020, Rianna Cantarelli
 * @license     MIT
 */
class Stream implements iStream
{





    /**
     * ``Stream`` que está carregado na instância.
     *
     * @var     resource
     */
    protected $stream = null;



    /**
     * Indica se o ``Stream`` atualmente carregado é do tipo ``pipe``.
     *
     * @var     bool
     */
    protected $isPipe = false;



    /**
     * Tamanho do ``Stream`` em bytes.
     * Será ``null`` caso o stream seja ``pipe`` ou caso seu tamanho não possa ser identificado.
     *
     * @var     ?int
     */
    protected $size = null;



    /**
     * Coleção de metadados referentes ao ``Stream`` que está atualmente carregado.
     *
     * @var     ?array
     */
    protected $metaData = null;



    /**
     * Indica quando o ``Stream`` é *pesquisável*.
     *
     * @var     bool
     */
    protected $seekable = false;



    /**
     * Indica quando o ``Stream`` pode ser escrito ou se está com o modo de escrita ativo.
     *
     * @var     bool
     */
    protected $writable = false;



    /**
     * Indica quando o ``Stream`` pode ser lido ou se está com o modo de leitura ativo.
     *
     * @var     bool
     */
    protected $readable = false;










    /**
     * Inicia um manipulador de ``Stream``.
     *
     * @param       resource $stream
     *              Objeto ``Stream`` que será manipulado.
     *
     * @throws      \InvalidArgumentException
     */
    function __construct($stream)
    {
        $this->attachResource($stream);
    }




    /**
     * Anexa o recurso indicado nesta instância.
     *
     * @param       resource $stream
     *              Recurso.
     *
     * @throws      \InvalidArgumentException
     *
     * @return      void
     */
    protected function attachResource($stream) : void
    {
        if (is_resource($stream) === false) {
            throw new \InvalidArgumentException("Argument must be a valid resource type.");
        }

        $this->stream = $stream;
        $stats = fstat($this->stream);


        // Identifica se o "Stream" é "pipe"
        $bitMask = 0010000;
        $this->isPipe = (($stats["mode"] & $bitMask) !== 0);

        // Identifica o tamanho do "Stream" (se possível).
        $this->size = ((isset($stats["size"]) && $this->isPipe === false) ? $stats["size"] : null);

        // Resgata os metadados do "Stream"
        $this->metaData = stream_get_meta_data($this->stream);

        // Verifica se o "Stream" é "pesquisável"
        $this->seekable = ($this->isPipe === false && $this->metaData["seekable"]);



        $streamModes = [
            "readable" => ["r", "r+", "w+", "a+", "x+", "c+"],
            "writable" => ["r+", "w", "w+", "a", "a+", "x", "x+", "c", "c+"]
        ];

        // Verifica se é possível alterar o "Stream"
        foreach ($streamModes["writable"] as $mode) {
            if (strpos($this->metaData["mode"], $mode) === 0) {
                $this->writable = true;
                break;
            }
        }


        // Verifica se é possível ler o "Stream"
        foreach ($streamModes["readable"] as $mode) {
            if (strpos($this->metaData["mode"], $mode) === 0) {
                $this->readable = true;
                break;
            }
        }
    }





    /**
     * Retorna um array associativo contendo metadados relacionados com a ``key`` indicada.
     * Retorna ``null`` caso a chave indicada não exista.
     *
     * Os dados retornados são identicos aos que seriam pegos pela função do PHP
     * ``stream_get_meta_data``.
     *
     * @link        http://php.net/manual/en/function.stream-get-meta-data.php
     *
     * @param       ?string $key
     *              Nome da chave de metadados que serão retornados.
     *
     * @return      mixed
     */
    public function getMetadata($key = null)
    {
        $r = null;
        if ($this->stream !== null && $key !== null && is_string($key) === true) {
            $r = ((isset($this->metaData[$key]) === false) ? null : $this->metaData[$key]);
        }
        return $r;
    }





    /**
     * Retorna ``true`` se o ``Stream`` carregado é *pesquisável*.
     *
     * @return      bool
     */
    public function isSeekable() : bool
    {
        return $this->seekable;
    }





    /**
     * Retorna ``true`` se é possível escrever no ``Stream`` ou se ele está com seu modo de
     * escrita ativo.
     *
     * @return      bool
     */
    public function isWritable() : bool
    {
        return $this->writable;
    }





    /**
     * Retorna ``true`` se é possível ler o ``Stream`` ou se ele está com seu modo de
     * leitura ativo.
     *
     * @return      bool
     */
    public function isReadable() : bool
    {
        return $this->readable;
    }





    /**
     * Retorna o tamanho (em bytes) do ``Stream`` carregado ou ``null`` caso ele não exista ou se
     * não for possível determinar.
     *
     * @return      ?int
     */
    public function getSize() : ?int
    {
        return $this->size;
    }










    /**
     * Retornará ``true`` caso o ponteiro do ``Stream`` esteja posicionado no final do arquivo.
     *
     * @return      bool
     */
    public function eof() : bool
    {
        return (($this->stream === null) ? true : feof($this->stream));
    }





    /**
     * Retorna a posição atual do ponteiro.
     *
     * @return      int
     *
     * @throws      \RuntimeException
     */
    public function tell() : int
    {
        $pos = null;
        $err = ($this->stream === null || $this->isPipe === true);

        if ($err === false) {
            $pos = ftell($this->stream);
            $err = ($pos === false);
        }

        if ($err === true) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Could not get the position of the pointer in stream.");
            // @codeCoverageIgnoreEnd
        }

        return $pos;
    }





    /**
     * Modifica a posição do cursor dentro do ``Stream`` conforme indicações ``offset`` e
     * ``whence``.
     *
     * Esta função tem funcionamento identico ao ``fseek`` do PHP.
     * Importante lembrar que conforme o modo de abertura do recurso (r ; rw; r+; a+ ...) esta
     * função pode não funcionar adequadamente.
     *
     * @link        http://www.php.net/manual/en/function.fseek.php
     *
     * @param       int $offset
     *              Posição que será definida para o cursor.
     *
     * @param       int $whence
     *              Especifica a forma como a posição do cursor será calculado.
     *              Valores válidos são ``SEEK_SET``, ``SEEK_CUR`` e ``SEEK_END``.
     *
     * @throws      \RuntimeException
     */
    public function seek($offset, $whence = SEEK_SET) : void
    {
        $r = -1;
        $err = ($this->stream === null || $this->seekable === false);

        if ($err === false) {
            $r = fseek($this->stream, $offset, $whence);
        }

        if ($err === true || $r === -1) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Fail on seek in stream.");
            // @codeCoverageIgnoreEnd
        }
    }





    /**
     * Posiciona o cursor do ``Stream`` no início do mesmo.
     * Se o ``Stream`` não for *pesquisável* então este método irá lançar uma exception.
     *
     * @see         seek()
     *
     * @link        http://www.php.net/manual/en/function.fseek.php
     *
     * @throws      \RuntimeException
     */
    public function rewind() : void
    {
        $r = false;
        $err = ($this->stream === null || $this->seekable === false);

        if ($err === false) {
            $r = rewind($this->stream);
        }

        if ($err === true || $r === false) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Could not rewind stream.");
            // @codeCoverageIgnoreEnd
        }
    }





    /**
     * Lê as informações do ``Stream`` carregado a partir da posição atual do cursor até onde
     * ``$length`` indicar.
     *
     * @param       int $length
     *              Tamanho da string que será retornada.
     *
     * @return      string
     *
     * @throws      \RuntimeException
     */
    public function read($length) : string
    {
        $r = false;
        $err = ($this->stream === null || $this->readable === false);

        if ($err === false) {
            $r = fread($this->stream, $length);
        }

        if ($err === true || $r === false) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Could not read from stream.");
            // @codeCoverageIgnoreEnd
        }

        return $r;
    }





    /**
     * Escreve no ``Stream`` carregado.
     * Retorna o número de bytes escritos no ``Stream``.
     *
     * @param       string $string
     *              Dados que serão escritos.
     *
     * @return      int
     *
     * @throws      \RuntimeException
     */
    public function write($string) : int
    {
        $r = false;
        $err = ($this->stream === null || $this->writable === false);

        if ($err === false) {
            $r = fwrite($this->stream, $string);
            $stats = fstat($this->stream);

            // Identifica o novo tamanho do "Stream" (se possível).
            $this->size = ((isset($stats["size"]) && $this->isPipe === false) ? $stats["size"] : null);
        }

        if ($err === true || $r === false) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Could not write to stream.");
            // @codeCoverageIgnoreEnd
        }

        return $r;
    }





    /**
     * A partir da posição atual do cursor, retorna o conteúdo do ``Stream`` em uma string.
     * Lança uma exception caso algum erro ocorra.
     *
     * @return      string
     *
     * @throws      \RuntimeException
     */
    public function getContents() : string
    {
        $r = false;
        $err = ($this->stream === null || $this->readable === false);

        if ($err === false) {
            $r = stream_get_contents($this->stream);
        }

        if ($err === true || $r === false) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException("Could not get contents of stream.");
            // @codeCoverageIgnoreEnd
        }

        return $r;
    }










    /**
     * Encerra o uso do ``Stream`` atualmente carregado para esta instância.
     * Retorna o objeto ``Stream`` em sua condição atual ou ``null`` caso ele não esteja definido.
     *
     * @return      ?resource
     */
    public function detach()
    {
        $stream = $this->stream;

        $this->stream = null;
        $this->isPipe = false;
        $this->size = null;

        $this->metaData = null;

        $this->seekable = false;
        $this->writable = false;
        $this->readable = false;

        return $stream;
    }





    /**
     * Encerra o ``Stream``.
     *
     * @return      void
     */
    public function close() : void
    {
        if ($this->stream !== null) {
            if ($this->isPipe === true) {
                // @codeCoverageIgnoreStart
                pclose($this->stream);
                // @codeCoverageIgnoreEnd
            } else {
                fclose($this->stream);
            }
        }

        $this->detach();
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
     * @codeCoverageIgnore
     *
     * @see         http://php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     * @return      string
     */
    public function __toString()
    {
        $r = "";

        if ($this->stream !== null) {
            try {
                $cursor = $this->tell();

                $this->rewind();
                $r = $this->getContents();

                $this->seek($cursor);
            } catch (\RuntimeException $ex) {
                $r = "";
            }
        }

        return $r;
    }
}
