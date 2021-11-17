.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Response
========


.. php:namespace:: AeonDigital\Http\Message

.. php:class:: Response


	.. rst-class:: phpdoc-description
	
		| Representa uma resposta ``Http`` à uma requisição feita por um ``UA``.
		
		| Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
		| seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
		| instância com a alteração necessária para o novo estado.
		| 
		| Implementação AeonDigital da interface ``Psr\Http\Message\ResponseInterface``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Message\\Abstracts\\aMessage`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Message\\iResponse` 
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\HttpRawStatusCode` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getStatusCode()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o código do status ``Http`` que está definido para esta resposta.
			
		
		
		:Returns: ‹ int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withStatus( $code, $reasonPhrase=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``method`` especificado.
			
		
		
		:Parameters:
			- ‹ int › **$code** |br|
			  Código do status ``Http`` a ser definido para a instância.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão do status a ser enviada em conjunto na resposta.
			  Se não for definida e o código informado for um código padrão, usará a frase
			  razão correspondente.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``code``.
		
	
	

.. rst-class:: public

	.. php:method:: public getReasonPhrase()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a ``frase razão`` para o código de status definido nesta instância.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getViewData()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o objeto ``viewData`` contendo as informações obtidas durante o processamento da
			| rota alvo.
			
			| Este objeto traz dados a serem usados no corpo da view.
			
		
		
		:Returns: ‹ ?\\StdClass ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withViewData( $viewData)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``viewData`` especificado.
			
		
		
		:Parameters:
			- ‹ ?\\StdClass › **$viewData** |br|
			  Objeto ``viewData``.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getViewConfig()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o objeto ``viewConfig`` contendo as informações obtidas durante o processamento da
			| rota alvo.
			
			| Este objeto traz dados que orientam a criação da view.
			
		
		
		:Returns: ‹ ?\\StdClass ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withViewConfig( $viewConfig)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``viewConfig`` especificado.
			
		
		
		:Parameters:
			- ‹ ?\\StdClass › **$viewConfig** |br|
			  Objeto ``viewConfig``.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withHeaders( $headers, $merge=false)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os ``headers`` especificados.
			
		
		
		:Parameters:
			- ‹ array › **$headers** |br|
			  Coleção de headers.
			- ‹ bool › **$merge** |br|
			  Quando ``true`` irá manter os headers já definidos e apenas adicionar ou
			  sobrescrever os definidos em ``$headers``.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withActionProperties( $viewData, $viewConfig, $headers)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``viewData`` e o ``viewConfig`` especificados.
			
		
		
		:Parameters:
			- ‹ ?\\StdClass › **$viewData** |br|
			  Objeto ``viewData``.
			- ‹ ?\\StdClass › **$viewConfig** |br|
			  Objeto ``viewConfig``.
			- ‹ ?array › **$headers** |br|
			  Coleção de headers.
			  Irá executar um Merge com os headers existentes.

		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Message\\iResponse ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $statusCode, $reasonPhrase, $httpVersion, $headers, $body, $viewData=null, $viewConfig=null)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``Response``.
			
		
		
		:Parameters:
			- ‹ int › **$statusCode** |br|
			  Código do status ``Http``.
			- ‹ string › **$reasonPhrase** |br|
			  Frase razão do status ``Http``.
			  Se não for definida e o código informado for um código padrão, usará a frase
			  razão correspondente.
			- ‹ string › **$httpVersion** |br|
			  Versão do protocolo ``Http``.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da
			  requisição.
			- ‹ AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto ``stream`` que faz parte do corpo da mensagem.
			- ‹ ?\\StdClass › **$viewData** |br|
			  Objeto ``viewData``.
			- ‹ ?\\StdClass › **$viewConfig** |br|
			  Objeto ``viewConfig``.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
	
	

