.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aAbsoluteUri
============


.. php:namespace:: AeonDigital\Http\Uri\Abstracts

.. rst-class::  abstract

.. php:class:: aAbsoluteUri


	.. rst-class:: phpdoc-description
	
		| Implementa a interface ``iAbsoluteUri``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Uri\\Abstracts\\aHierPartUri`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Uri\\iAbsoluteUri` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getQuery()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``query`` da ``URI`` ou ``''`` caso ele não esteja especificado.
			
			| O caracter ``?`` não faz parte do componente ``query``.
			| 
			| Os valores definidos serão retornados usando ``percent-encoding``.
			
		
		
		:See: https://tools.ietf.org/html/rfc3986#section-3.4 
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withQuery( $query)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``query`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$query** |br|
			  O novo valor para ``query`` na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``query``.
		
	
	

.. rst-class:: public

	.. php:method:: public getFragment()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o componente ``fragment`` da ``URI`` ou ``''`` caso ele não esteja especificado.
			
			| O caracter ``#`` não faz parte do componente ``fragment``.
			| 
			| Os valores definidos serão retornados usando ``percent-encoding``.
			
		
		
		:See: https://tools.ietf.org/html/rfc3986#section-3.4 
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withFragment( $fragment)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``fragment`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$fragment** |br|
			  O novo valor para ``fragment`` na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``fragment``.
		
	
	

.. rst-class:: public

	.. php:method:: public withRelativeUri( $path=&#34;&#34;, $query=&#34;&#34;, $fragment=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo a parte ``relative-uri`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$path** |br|
			  O novo valor para ``path`` na nova instância.
			- ‹ string › **$query** |br|
			  O novo valor para ``query`` na nova instância.
			- ‹ string › **$fragment** |br|
			  O novo valor para ``fragment`` na nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para algum argumento.
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $scheme=&#34;&#34;, $user=&#34;&#34;, $password=null, $host=&#34;&#34;, $port=null, $path=&#34;&#34;, $query=&#34;&#34;, $fragment=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância ``absoluteUri`` de uma ``URI``.
			
		
		
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
			- ‹ string › **$query** |br|
			  Define o ``query`` usado pelo ``URI``.
			- ‹ string › **$fragment** |br|
			  Define o ``fragment`` usado pelo ``URI``.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos parametros passados seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public getAbsoluteUri( $withFragment=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string que representa toda a uri representada pela atual instância.
			
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ scheme &#34;:&#34; ][ &#34;//&#34; authority ][ &#34;/&#34; path ][ &#34;?&#34; query ][ &#34;#&#34; fragment ]
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ bool › **$withFragment** |br|
			  Quando ``true`` irá adicionar o componente ``fragment``.
			  Se ``false`` irá omitir totalmente este componente.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getRelativeUri( $withFragment=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string que representa toda a parte relativa da ``URI`` atualmente representada
			| pela instância.
			
			| O resultado será uma string com o seguinte formato:
			| 
			| \`\`\`
			|  [ &#34;/&#34; path ][ &#34;?&#34; query ][ &#34;#&#34; fragment ]
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ bool › **$withFragment** |br|
			  Quando ``true`` irá adicionar o componente ``fragment``.
			  Se ``false`` irá omitir totalmente este componente.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromString( $uri)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma nova instância definida a partir do valor indicado na string ``$uri``.
			
		
		
		:Parameters:
			- ‹ string › **$uri** |br|
			  ``URI`` que será usada de base para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Exception lançada caso a ``URI`` indicada seja inválida.
		
	
	

.. rst-class:: public

	.. php:method:: public __toString()
	
		.. rst-class:: phpdoc-description
		
			| Converte os atributos que formam a ``URI`` em uma string válida para seu respectivo ``scheme``.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

