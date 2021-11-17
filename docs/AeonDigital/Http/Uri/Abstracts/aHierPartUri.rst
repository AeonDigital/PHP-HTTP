.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aHierPartUri
============


.. php:namespace:: AeonDigital\Http\Uri\Abstracts

.. rst-class::  abstract

.. php:class:: aHierPartUri


	.. rst-class:: phpdoc-description
	
		| Implementa a interface ``iHierPartUri``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Uri\\Abstracts\\aBasicUri`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Uri\\iHierPartUri` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getUser()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``user`` da ``URI`` ou ``''`` caso ele não esteja especificado.
			
			| O valor será retornado usando ``percent-encoding``.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withUser( $user)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``user`` especificado.
			
		
		
		:Parameters:
			- ‹ ?string › **$user** |br|
			  O novo valor para ``user`` para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``user``.
		
	
	

.. rst-class:: public

	.. php:method:: public getPassword()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``password`` da ``URI``.
			
			| Uma ``password`` pode ser uma string vazia, portanto o valor ``null`` indica quando ela
			| não está setada.
			| O valor será retornado usando ``percent-encoding``.
			
		
		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withPassword( $password=null)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``password`` especificado.
			
		
		
		:Parameters:
			- ‹ ?string › **$password** |br|
			  O novo valor para ``password`` para a nova instância.
			  Se ``null`` for passado, o valor da ``password`` será removido.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``password``.
		
	
	

.. rst-class:: public

	.. php:method:: public getHost()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``host`` da ``URI`` ou ``''`` caso ele não esteja especificado.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withHost( $host)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``host`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$host** |br|
			  O novo valor para ``host`` para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``host``.
		
	
	

.. rst-class:: public

	.. php:method:: public getPort()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``port`` da ``URI`` ou ``null`` caso a porta definida seja a padrão
			| para o ``scheme`` que está sendo usado.
			
		
		
		:Returns: ‹ ?int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDefaultPort()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a porta padrão para o ``scheme`` definido para este ``URI``.
			
			| Se o ``scheme`` não possui uma porta padrão deverá ser retornado ``null``.
			
		
		
		:Returns: ‹ ?int ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withPort( $port)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``port`` especificado.
			
		
		
		:Parameters:
			- ‹ ?int › **$port** |br|
			  O novo valor para ``port`` para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``port``.
		
	
	

.. rst-class:: public

	.. php:method:: public getUserInfo()
	
		.. rst-class:: phpdoc-description
		
			| Componente ``user information`` da ``URI``.
			
			| Se este componente não estiver presente na ``URI`` será retornado ``''``.
			| Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
			| este formato.
			| 
			| A sintaxe padrão deste componente é:
			| 
			| \`\`\`
			|  [username[:password]]
			| \`\`\`
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withUserInfo( $user, $password=null)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``user information`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$user** |br|
			  O novo valor para ``user`` na nova instância.
			- ‹ string › **$password** |br|
			  O novo valor para ``password`` na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para algum argumento.
		
	
	

.. rst-class:: public

	.. php:method:: public getAuthority()
	
		.. rst-class:: phpdoc-description
		
			| Componente ``authority`` da ``URI``.
			
			| Os componentes que são armazenados usando ``percent-encoding`` serão retornados já usando
			| este formato.
			| 
			| A sintaxe padrão deste componente é:
			| 
			| \`\`\`
			|  [[user-info@]host[:port]]
			| \`\`\`
			| 
			| O componente ``port`` deve ser omitido quando esta não estiver definida, ou, se for uma
			| das portas padrão para o ``scheme`` atualmente em uso.
			
		
		
		:See: https://tools.ietf.org/html/rfc3986#section-3.2 
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withAuthority( $user=&#34;&#34;, $password=null, $host=&#34;&#34;, $port=null)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo a parte &#34;autority&#34; especificado.
			
		
		
		:Parameters:
			- ‹ string › **$user** |br|
			  O novo valor para ``user`` na nova instância.
			- ‹ ?string › **$password** |br|
			  O novo valor para ``password`` para a nova instância.
			  Se ``null`` for passado, o valor da ``password`` será removido.
			- ‹ string › **$host** |br|
			  O novo valor para ``host`` na nova instância.
			- ‹ ?int › **$port** |br|
			  O novo valor para ``port`` na nova instância.
			  Use ``null`` para ignorar usar o valor padrão para o ``scheme``.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para algum argumento.
		
	
	

.. rst-class:: public

	.. php:method:: public getPath()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``path`` da ``URI`` ou ``''`` caso ele não esteja especificado.
			
			| O valor será retornado usando ``percent-encoding``.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withPath( $path)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``path`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$path** |br|
			  O novo valor para ``path`` para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``path``.
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $scheme=&#34;&#34;, $user=&#34;&#34;, $password=null, $host=&#34;&#34;, $port=null, $path=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância ``authority`` de uma ``URI``.
			
		
		
		:Parameters:
			- ‹ string › **$scheme** |br|
			  Define o ``scheme`` usado pelo ``URI``.
			- ‹ string › **$user** |br|
			  Define o ``user`` usado pelo ``URI``.
			- ‹ ?string › **$password** |br|
			  Define o ``password`` usado pelo ``URI``.
			  Se ``null`` for passado, o valor da ``password`` não será removido.
			- ‹ string › **$host** |br|
			  Define o ``host`` usado pelo ``URI``.
			- ‹ ?int › **$port** |br|
			  Define a ``port`` usado pelo ``URI``.
			  Use ``null`` para usar o valor padrão para do ``scheme``.
			- ‹ string › **$path** |br|
			  Define o ``path`` usado pelo ``URI``.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos parametros passados seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public getBase()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string que representa a parte básica da ``URI`` representada pela instância.
			
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ scheme &#34;:&#34; ][ &#34;//&#34; authority ]
			| \`\`\`
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getBasePath()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string que representa toda a parte hierarquica da ``URI`` representada pela
			| instância.
			
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ scheme &#34;:&#34; ][ &#34;//&#34; authority ][ &#34;/&#34; path ]
			| \`\`\`
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

