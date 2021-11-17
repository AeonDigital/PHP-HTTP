.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Request
=======


.. php:namespace:: AeonDigital\Http\Message

.. php:class:: Request


	.. rst-class:: phpdoc-description
	
		| Representa uma requisição ``Http`` feita por um ``UA``.
		
		| Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
		| seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
		| instância com a alteração necessária para o novo estado.
		| 
		| Implementação AeonDigital da interface ``Psr\Http\Message\RequestInterface``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Message\\Abstracts\\aMessage`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Message\\iRequest` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getMethod()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o método ``Http`` que está sendo usado na requisição.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withMethod( $method)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``method`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$method** |br|
			  O ``method`` que será usado na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``method``.
		
	
	

.. rst-class:: public

	.. php:method:: public getUri()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a instância ``iUrl`` que está sendo executada.
			
		
		
		:Returns: ‹ \\AeonDigital\\Interfaces\\Http\\Uri\\iUrl ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withUri( $uri, $preserveHost=false)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o objeto ``iUrl`` especificado.
			
		
		
		:Parameters:
			- ‹ Psr\\Http\\Message\\UriInterface › **$uri** |br|
			  O objeto ``uri`` que será usado na nova instância.
			- ‹ bool › **$preserveHost** |br|
			  Preserva o estado original do Header ``Host``.

		
		:Returns: ‹ static ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRequestTarget()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string que representa a requisição que está sendo executada para o domínio
			| atual.
			
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ &#34;/&#34; path ][ &#34;?&#34; query ][ &#34;#&#34; fragment ]
			| \`\`\`
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withRequestTarget( $requestTarget)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo o ``requestTarget`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$requestTarget** |br|
			  Valor de ``requestTarget`` que será usado na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``requestTarget``.
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $httpMethod, $uri, $httpVersion, $headers, $body)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto Request.
			
		
		
		:Parameters:
			- ‹ string › **$httpMethod** |br|
			  Método ``Http`` que está sendo usado para a requisição.
			- ‹ AeonDigital\\Interfaces\\Http\\Uri\\iUrl › **$uri** |br|
			  Objeto que implementa a interface ``iUrl`` configurado com a ``URI`` que
			  está sendo requisitada pelo UA.
			- ‹ string › **$httpVersion** |br|
			  Versão do protocolo ``Http``.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection`` cotendo os cabeçalhos da
			  requisição.
			- ‹ AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto stream que faz parte do corpo da mensagem.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
	
	

