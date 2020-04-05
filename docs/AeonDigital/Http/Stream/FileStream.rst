.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


FileStream
==========


.. php:namespace:: AeonDigital\Http\Stream

.. php:class:: FileStream


	.. rst-class:: phpdoc-description
	
		| Extende a classe ``Stream`` para especializar-se em representar um arquivo físico e existente
		| no servidor atual.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Stream\\Stream`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Stream\\iFileStream` 
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\MimeTypeData` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getPathToFile()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o caminho completo até onde o arquivo está no momento.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getFilename()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do arquivo.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getMimeType()
	
		.. rst-class:: phpdoc-description
		
			| Resgata o mimetype do arquivo.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $pathToFile, $openMode=&#34;r&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo manipulador ``FileStream``.
			
		
		
		:Parameters:
			- ‹ string › **$pathToFile** |br|
			  Caminho completo até o arquivo alvo.
			- ‹ string › **$openMode** |br|
			  Modo de abertura do stream.

		
		:Returns: ‹ void ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o arquivo indicado não exista.
		
	
	

.. rst-class:: public

	.. php:method:: public setFileStream( $pathToFile, $openMode=null)
	
		.. rst-class:: phpdoc-description
		
			| Define um novo arquivo alvo para a instância ``FileStream``.
			
			| Use o método ``detach`` para liberar o recurso atual para outras ações.
			
		
		
		:Parameters:
			- ‹ string › **$pathToFile** |br|
			  Caminho completo até o arquivo alvo.
			- ‹ ?string › **$openMode** |br|
			  Modo de abertura do stream.
			  Se for mantido ``null``, o novo arquivo deve utilizar o mesmo modo usado
			  pelo anterior.

		
		:Returns: ‹ void ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o arquivo indicado não exista.
		
	
	

