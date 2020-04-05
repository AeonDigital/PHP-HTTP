.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


File
====


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: File


	.. rst-class:: phpdoc-description
	
		| Representa um arquivo sendo enviado por um ``UA``.
		
		| Esta classe implementa a interface
		| ``Psr\Http\Message\UploadedFileInterface`` através da interface ``iFile``.
		
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iFile` 
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\MimeTypeData` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getStream()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho completo até onde o arquivo está no momento.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iFileStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSize()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o tamanho (em bytes) do ``Stream`` carregado.
			
			| Retornará ``null`` quando o stream for liberado usando o método ``dropStream``.
			
		
		
		:Returns: ‹ ?int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPathToFile()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho completo para onde o arquivo está salvo no servidor.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getClientFilename()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do arquivo que está sendo enviado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getClientMediaType()
	
		.. rst-class:: phpdoc-description
		
			| Resgata o mimetype do arquivo que está sendo enviado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public dropStream()
	
		.. rst-class:: phpdoc-description
		
			| Libera o ``stream`` para que o recurso possa ser usado por outra tarefa.
			
			| Após esta ação os métodos da instância que dependem diretamente do recurso que foi
			| liberado não irão funcionar.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getError()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o erro ao efetuar o upload do arquivo, se houver.
			
			| Não havendo erro o valor retornado é equivalente a constante ``UPLOAD_ERR_OK``
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $fileStream, $clientFilename=null, $uploadError=UPLOAD_ERR_OK)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``File``.
			
		
		
		:Parameters:
			- ‹ AeonDigital\\Interfaces\\Stream\\iFileStream › **$fileStream** |br|
			  Stream que representa o arquivo que está sendo enviado pelo ``UA``.
			- ‹ int › **$uploadError** |br|
			  Código de erro ao efetuar o upload, caso exista.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o arquivo indicado não exista.
		
	
	

.. rst-class:: public

	.. php:method:: public moveTo( $targetPath)
	
		.. rst-class:: phpdoc-description
		
			| Move o arquivo carregado para a nova localização.
			
			| Esta ação só pode ser executada 1 vez pois o arquivo na posição original será excluido ao
			| final do processo.
			
		
		
		:Parameters:
			- ‹ string › **$targetPath** |br|
			  Caminho completo até o novo local onde o arquivo deve ser salvo.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o destino especificado seja inválido
		
		:Throws: ‹ \RuntimeException ›|br|
			  Quando alguma operação de mover ou excluir falhar.
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o destino especificado seja inválido
		
		:Throws: ‹ \RuntimeException ›|br|
			  Quando alguma operação de mover ou excluir falhar.
		
	
	

