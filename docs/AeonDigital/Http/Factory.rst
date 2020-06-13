.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Factory
=======


.. php:namespace:: AeonDigital\Http

.. php:class:: Factory


	.. rst-class:: phpdoc-description
	
		| Implementação de ``iFactory``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\iFactory` 
	

Methods
-------

.. rst-class:: public

	.. php:method:: public createHeaderCollection( $initialValues=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de headers baseado nos valores passados.
			
			| O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iHeaderCollection``.
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores iniciais dos headers.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createCookieCollection( $initialValues=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de headers baseado nos valores passados.
			
			| O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iCookieCollection``.
			
		
		
		:Parameters:
			- ‹ ?string | array › **$initialValues** |br|
			  Valores iniciais para a coleção de cookies.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createQueryStringCollection( $initialValues=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de headers baseado nos valores passados.
			
			| O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iQueryStringCollection``.
			
		
		
		:Parameters:
			- ‹ ?string | array › **$initialValues** |br|
			  Valores iniciais para a coleção de cookies.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createFileCollection( $initialValues=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de headers baseado nos valores passados.
			
			| O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Http\Data\iFileCollection``.
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores iniciais para a coleção de cookies.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Data\\iFileCollection ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createCollection( $initialValues=[], $autoincrement=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto ``iCollection`` vazio.
			
			| O objeto retornado deve implementar a interface ``AeonDigital\Interfaces\Collection\iCollection``.
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores com os quais a instância deve iniciar.
			- ‹ bool › **$autoincrement** |br|
			  Quando ``true`` permite que seja omitido o nome da chave dos valores pois
			  eles serão definidos internamente conforme fosse um array começando em zero.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Collection\\iCollection ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createUri( $uri=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Uri\iUrl``.
			
		
		
		:Parameters:
			- ‹ string › **$uri** |br|
			  Uri.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Uri\\iUrl ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso a ``uri`` passada seja inválida.
		
	
	

.. rst-class:: public

	.. php:method:: public createStream( $content=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
			
		
		
		:Parameters:
			- ‹ string › **$content** |br|
			  Conteúdo inicial.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromFile( $filename, $mode=&#34;r&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iFileStream``.
			
		
		
		:Parameters:
			- ‹ string › **$filename** |br|
			  Caminho completo até o arquivo.
			- ‹ string › **$mode** |br|
			  Modo no qual o stream será aberto.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iFileStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromResource( $resource)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
			
		
		
		:Parameters:
			- ‹ resource › **$resource** |br|
			  Recurso que será aberto no stream.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createStreamFromBodyRequest()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Stream\iStream``.
			
			| O objeto criado deve ser baseado no ``stream`` do ``body`` da requisição que está
			| ocorrendo no momento.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public createRequest( $httpMethod, $uri, $httpVersion=null, $headers=null, $body=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iRequest``.
			
		
		
		:Parameters:
			- ‹ string › **$httpMethod** |br|
			  Método ``HTTP`` que está sendo usado para a requisição.
			- ‹ string › **$uri** |br|
			  ``URI`` que está sendo executada.
			- ‹ ?string › **$httpVersion** |br|
			  Versão do protocolo ``HTTP``.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto ``stream`` que faz parte do corpo da mensagem.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iRequest ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos argumentos passados seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public createServerRequest( $httpMethod, $uri, $httpVersion=null, $headers=null, $body=null, $cookies=null, $queryStrings=null, $files=null, $serverParans=null, $attributes=null, $bodyParsers=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iServerRequest``.
			
		
		
		:Parameters:
			- ‹ string › **$httpMethod** |br|
			  Método ``HTTP`` que está sendo usado para a requisição.
			- ‹ string › **$uri** |br|
			  ``URI`` que está sendo executada.
			- ‹ ?string › **$httpVersion** |br|
			  Versão do protocolo ``HTTP``.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto ``stream`` que faz parte do corpo da mensagem.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection › **$cookies** |br|
			  Objeto que implementa ``iCookieCollection`` cotendo os cookies da requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection › **$queryStrings** |br|
			  Objeto que implementa ``iQueryStringCollection`` cotendo os queryStrings da ``URI``.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iFileCollection › **$files** |br|
			  Objeto que implementa ``iFileCollection`` cotendo os arquivos enviados nesta
			  requisição.
			- ‹ ?array › **$serverParans** |br|
			  Coleção de parametros definidos pelo servidor sobre o ambiente e requisição
			  atual.
			- ‹ ?\\AeonDigital\\Interfaces\\Collection\\iCollection › **$attributes** |br|
			  Objeto que implementa ``iCollection`` cotendo atributos personalizados para
			  esta requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Collection\\iCollection › **$bodyParsers** |br|
			  Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar
			  o processamento do body da requisição.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iServerRequest ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos argumentos passados seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public createResponse( $statusCode=200, $reasonPhrase=&#34;&#34;, $httpVersion=null, $headers=null, $body=null, $viewData=null, $mime=null, $locale=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna um objeto que implemente a interface ``AeonDigital\Interfaces\Http\Message\iResponse``.
			
		
		
		:Parameters:
			- ‹ int › **$statusCode** |br|
			  Código do status ``HTTP``.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão do status ``HTTP``.
			  Se não for definida e o código informado for um código padrão, usará a frase
			  razão correspondente.
			- ‹ ?string › **$httpVersion** |br|
			  Versão do protocolo ``HTTP``.
			- ‹ ?\\AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection``
			  cotendo os cabeçalhos da requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto ``stream`` que faz parte do corpo da mensagem.
			- ‹ ?\\StdClass › **$viewData** |br|
			  Objeto ``viewData``.
			- ‹ ?string › **$mime** |br|
			  Mimetype que deve ser usado para criar o corpo da mensagem.
			- ‹ ?string › **$locale** |br|
			  Locale no qual a informação que consta no corpo da mensagem está construído.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos argumentos passados seja inválido.
		
	
	

