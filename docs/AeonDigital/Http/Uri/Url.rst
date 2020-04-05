.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Url
===


.. php:namespace:: AeonDigital\Http\Uri

.. php:class:: Url


	.. rst-class:: phpdoc-description
	
		| Classe concreta de uma Url.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Uri\\Abstracts\\aAbsoluteUri`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Uri\\iUrl` 
	

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $scheme=&#34;&#34;, $user=&#34;&#34;, $password=null, $host=&#34;&#34;, $port=null, $path=&#34;&#34;, $query=&#34;&#34;, $fragment=&#34;&#34;)
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância ``Url``.
			
		
		
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
		
	
	

