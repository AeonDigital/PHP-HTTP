.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aMessage
========


.. php:namespace:: AeonDigital\Http\Message\Abstracts

.. rst-class::  abstract

.. php:class:: aMessage


	.. rst-class:: phpdoc-description
	
		| Fornece as operações básicas para o uso de mensagens ``Http`` (request ou response).
		
		| Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
		| seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
		| instância com a alteração necessária para o novo estado.
		| 
		| Esta classe implementa a interface interface
		| ``Psr\Http\Message\MessageInterface``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`Psr\\Http\\Message\\MessageInterface` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getProtocolVersion()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a versão do protocolo Http sendo usado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withProtocolVersion( $protocolVersion)
	
		.. rst-class:: phpdoc-description
		
			| Este método DEVE manter o estado da instância atual e retornar
			| uma nova instância contendo o &#34;protocolVersion&#34; especificado.
			
		
		
		:Parameters:
			- ‹ string › **$protocolVersion** |br|
			  O novo valor para &#34;protocolVersion&#34; na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para &#34;protocolVersion&#34;.
		
	
	

.. rst-class:: public

	.. php:method:: public getHeaders()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array associativo onde cada chave é um header Http
			| usado na mensagem.
			
			| Valores múltiplos (separados por virgula) serão quebrados
			| em um novo array de valores.
			| 
			| O formato do nome do header é mantido conforme ele foi definido.
			
		
		
		:Returns: ‹ array[][] ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public hasHeader( $name)
	
		.. rst-class:: phpdoc-description
		
			| Verifica se um determinado header já existe.
			
			| Esta método é &#34;case-insensitive&#34;.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header alvo.

		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getHeader( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna a coleção de valores que o header de nome indicado possui
			| no momento. Um array vazio será retornado caso o header não exista.
			
			| Esta método é &#34;case-insensitive&#34;.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header alvo.

		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getHeaderLine( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string representando toda a coleção de valores determinados
			| para o header de nome indicado. Cada valor é separado por virgula.
			
			| Esta método é &#34;case-insensitive&#34;.
			| 
			| Uma string vazia será retornada caso o header não exista.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header alvo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withHeader( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Este método DEVE manter o estado da instância atual e retornar
			| uma nova instância contendo o novo valor para o &#34;header&#34; especificado.
			
			| Este método substitui integralmente o valor do &#34;header&#34; pelo novo valor
			| caso já exista um para a chave indicada..
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header.
			- ‹ string | array › **$value** |br|
			  Valor do header.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para o nome ou valor do header.
		
	
	

.. rst-class:: public

	.. php:method:: public withAddedHeader( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Este método DEVE manter o estado da instância atual e retornar
			| uma nova instância contendo a adição feita para o &#34;header&#34; especificado.
			
			| Este método pode/deve adicionar o novo &#34;header&#34; na coleção existente
			| caso ele não exista e, se existir, incrementar seu valor atual com o
			| valor informado.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header.
			- ‹ string | array › **$value** |br|
			  Valores a serem adicionados ao header.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para o nome ou valor do header.
		
	
	

.. rst-class:: public

	.. php:method:: public withoutHeader( $name)
	
		.. rst-class:: phpdoc-description
		
			| Este método DEVE manter o estado da instância atual e retornar
			| uma nova instância sem o &#34;header&#34; especificado.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do header.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para o nome do header.
		
	
	

.. rst-class:: public

	.. php:method:: public getBody()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o objeto &#34;Stream&#34; que forma o corpo da mensagem Http.
			
			| O objeto deve implementar a interface &#34;iStream&#34;.
			
		
		
		:See: http://www.php-fig.org/psr/ 
		:Returns: ‹ \\AeonDigital\\Interfaces\\Stream\\iStream ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withBody( $body)
	
		.. rst-class:: phpdoc-description
		
			| Este método DEVE manter o estado da instância atual e retornar
			| uma nova instância contendo o &#34;body&#34; especificado.
			
		
		
		:Parameters:
			- ‹ Psr\\Http\\Message\\StreamInterface › **$body** |br|
			  Objeto &#34;StreamInterface&#34;.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para o novo &#34;body&#34;.
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $version, $headers, $body)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto que representa uma mensagem Http.
			
		
		
		:Parameters:
			- ‹ string › **$version** |br|
			  Versão do protocolo Http
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa &#34;iHeaderCollection&#34;
			  cotendo os cabeçalhos da requisição.
			- ‹ AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto &#34;Stream&#34; representando o corpo da mensagem.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __set( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Desabilita a função mágica &#34;__set&#34; para assegurar a imutabilidade
			| da instância conforme definido na interface &#34;iUri&#34;.
			
		
		
	
	

