.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aBasicUri
=========


.. php:namespace:: AeonDigital\Http\Uri\Abstracts

.. rst-class::  abstract

.. php:class:: aBasicUri


	.. rst-class:: phpdoc-description
	
		| Implementa a interface ``iBasicUri``.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Uri\\iBasicUri` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getScheme()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome do ``scheme`` que o ``URI`` da classe está usando.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withScheme( $scheme)
	
		.. rst-class:: phpdoc-description
		
			| Este método ``DEVE`` manter o estado da instância atual e retornar uma nova instância
			| contendo o ``scheme`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$scheme** |br|
			  O novo valor para ``scheme`` para a nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``scheme``.
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $scheme=&#34;&#34;, $acceptSchemes=[])
	
		.. rst-class:: phpdoc-description
		
			| Inicia uma instância básica de uma ``URI``.
			
		
		
		:Parameters:
			- ‹ string › **$scheme** |br|
			  Define o ``scheme`` usado pelo ``URI``.
			- ‹ array › **$acceptSchemes** |br|
			  Coleção de ``schemes`` permitidos para a serem definidos por uma classe
			  concreta.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos parametros passados seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public __set( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Desabilita a função mágica ``__set`` para assegurar a imutabilidade da instância conforme
			| definido na interface ``iUri``.
			
		
		
	
	

