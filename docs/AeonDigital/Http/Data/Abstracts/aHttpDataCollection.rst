.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


aHttpDataCollection
===================


.. php:namespace:: AeonDigital\Http\Data\Abstracts

.. rst-class::  abstract

.. php:class:: aHttpDataCollection


	.. rst-class:: phpdoc-description
	
		| Classe abstrata que serve de base para as demais
		| collections de dados HTTP.
		
	
	:Parent:
		:php:class:`AeonDigital\\Collection\\Collection`
	

Methods
-------

.. rst-class:: public abstract static

	.. php:method:: public abstract static fromString( $str)
	
		.. rst-class:: phpdoc-description
		
			| Utiliza as informações da string indicada para iniciar uma nova
			| coleção de dados.
			
		
		
		:Parameters:
			- ‹ string › **$str** |br|
			  String que será convertida em uma nova coleção.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso a string passada seja inválida para construção de
			  uma nova coleção.
		
	
	

