.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Stream
======


.. php:namespace:: AeonDigital\Http\Stream

.. php:class:: Stream


	.. rst-class:: phpdoc-description
	
		| Fornece as operações básicas para o tratamento de Stream (fluxo) de dados.
		
		| ``Streams`` podem ser arquivos de qualquer natureza, um buffer ou mesmo um espaço na memória.
		| 
		| Em PHP, geralmente os ``Streams`` são iniciados usando o comando ``fopen`` e é importante
		| lembrar que o modo com o qual o recurso foi aberto influencia a capacidade desta classe.
		| 
		| Esta classe implementa a interface
		| ``Psr\Http\Message\StreamInterface`` através da interface ``iStream``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Stream\\iStream` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $stream)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um manipulador de ``Stream``.
			
		
		
		:Parameters:
			- ‹ resource › **$stream** |br|
			  Objeto ``Stream`` que será manipulado.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMetadata( $key=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo contendo metadados relacionados com a ``key`` indicada.
			
			| Retorna ``null`` caso a chave indicada não exista.
			| 
			| Os dados retornados são identicos aos que seriam pegos pela função do PHP
			| ``stream_get_meta_data``.
			
		
		
		:Parameters:
			- ‹ ?string › **$key** |br|
			  Nome da chave de metadados que serão retornados.

		
		:Returns: ‹ mixed ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public isSeekable()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se o ``Stream`` carregado é *pesquisável*.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public isWritable()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se é possível escrever no ``Stream`` ou se ele está com seu modo de
			| escrita ativo.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public isReadable()
	
		.. rst-class:: phpdoc-description
		
			| Retorna ``true`` se é possível ler o ``Stream`` ou se ele está com seu modo de
			| leitura ativo.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSize()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o tamanho (em bytes) do ``Stream`` carregado ou ``null`` caso ele não exista ou se
			| não for possível determinar.
			
		
		
		:Returns: ‹ ?int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public eof()
	
		.. rst-class:: phpdoc-description
		
			| Retornará ``true`` caso o ponteiro do ``Stream`` esteja posicionado no final do arquivo.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public tell()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a posição atual do ponteiro.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public seek( $offset, $whence=SEEK_SET)
	
		.. rst-class:: phpdoc-description
		
			| Modifica a posição do cursor dentro do ``Stream`` conforme indicações ``offset`` e
			| ``whence``.
			
			| Esta função tem funcionamento identico ao ``fseek`` do PHP.
			| Importante lembrar que conforme o modo de abertura do recurso (r ; rw; r+; a+ ...) esta
			| função pode não funcionar adequadamente.
			
		
		
		:Parameters:
			- ‹ int › **$offset** |br|
			  Posição que será definida para o cursor.
			- ‹ int › **$whence** |br|
			  Especifica a forma como a posição do cursor será calculado.
			  Valores válidos são ``SEEK_SET``, ``SEEK_CUR`` e ``SEEK_END``.

		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public rewind()
	
		.. rst-class:: phpdoc-description
		
			| Posiciona o cursor do ``Stream`` no início do mesmo.
			
			| Se o ``Stream`` não for *pesquisável* então este método irá lançar uma exception.
			
		
		
		:See: \AeonDigital\Http\Stream\seek() 
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public read( $length)
	
		.. rst-class:: phpdoc-description
		
			| Lê as informações do ``Stream`` carregado a partir da posição atual do cursor até onde
			| ``$length`` indicar.
			
		
		
		:Parameters:
			- ‹ int › **$length** |br|
			  Tamanho da string que será retornada.

		
		:Returns: ‹ string ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public write( $string)
	
		.. rst-class:: phpdoc-description
		
			| Escreve no ``Stream`` carregado.
			
			| Retorna o número de bytes escritos no ``Stream``.
			
		
		
		:Parameters:
			- ‹ string › **$string** |br|
			  Dados que serão escritos.

		
		:Returns: ‹ int ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getContents()
	
		.. rst-class:: phpdoc-description
		
			| A partir da posição atual do cursor, retorna o conteúdo do ``Stream`` em uma string.
			
			| Lança uma exception caso algum erro ocorra.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public detach()
	
		.. rst-class:: phpdoc-description
		
			| Encerra o uso do ``Stream`` atualmente carregado para esta instância.
			
			| Retorna o objeto ``Stream`` em sua condição atual ou ``null`` caso ele não esteja definido.
			
		
		
		:Returns: ‹ ?resource ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public close()
	
		.. rst-class:: phpdoc-description
		
			| Encerra o ``Stream``.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __toString()
	
		.. rst-class:: phpdoc-description
		
			| Este método retorna todo o conteúdo do ``Stream`` em uma string.
			
			| Para isso, primeiro o cursor é reposicionado no início do mesmo e então seu conteúdo é
			| retornado.
			| 
			| Ao final do processo, se possível (conforme o modo no qual o arquivo está aberto) o cursor
			| será reposicionado onde estava imediatamente antes da execução deste método. Este
			| comportamento é próprio desta implementação.
			
		
		
		:See: http://php.net/manual/en/language.oop5.magic.php#object.tostring 
		:Returns: ‹ string ›|br|
			  
		
	
	

