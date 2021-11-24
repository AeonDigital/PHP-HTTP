.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Execute
=======


.. php:namespace:: AeonDigital\Http

.. php:class:: Execute


	.. rst-class:: phpdoc-description
	
		| Implementação de ``iExecute``.
		
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\iExecute` 
	

Properties
----------

Methods
-------

.. rst-class:: public static

	.. php:method:: public static getLastError()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o status do último erro ocorrido após o a última requisição executada.
			
			| O Valor vazio &#34;&#34; indica que nenhum erro ocorreu.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static request( $method, $absoluteURL, $content=[], $headers=[])
	
		.. rst-class:: phpdoc-description
		
			| Efetua uma requisição ``Http``.
			
			| Qualquer tipo de falha encontrada fará retornar ``null``.
			
		
		
		:Parameters:
			- ‹ string › **$method** |br|
			  Método ``Http`` que será executado.
			- ‹ string › **$absoluteURL** |br|
			  ``URL`` alvo.
			- ‹ array › **$content** |br|
			  Array associativo com as chaves e valores que serão enviados.
			- ‹ array › **$headers** |br|
			  Array associativo com cabeçalhos ``Http`` para serem enviados na requisição.

		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static download( $absoluteURL, $absoluteSystemPathToDir, $fileName=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Efetua o download de um arquivo a partir de uma ``URL`` e salva-o no diretório indicado
			| com o nome escolhido.
			
		
		
		:Parameters:
			- ‹ string › **$absoluteURL** |br|
			  ``URL`` de onde o arquivo será resgatado.
			- ‹ string › **$absoluteSystemPathToDir** |br|
			  Diretório da aplicação onde o arquivo será salvo.
			- ‹ string › **$fileName** |br|
			  Nome usado para salvar o arquivo.
			  Se não informado será usado o nome original do mesmo.

		
		:Returns: ‹ bool ›|br|
			  
		
	
	

