.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


CookieCollection
================


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: CookieCollection


	.. rst-class:: phpdoc-description
	
		| Coleção que permite agrupar Cookies.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Data\\Abstracts\\aHttpDataCollection`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection` 
	

Methods
-------

.. rst-class:: public

	.. php:method:: public toString( $originalKeys=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma representação dos dados da coleção em formato de string.
			
		
		
		:Parameters:
			- ‹ ?bool › **$originalKeys** |br|
			  Quando ``true`` irá usar as chaves conforme foram definidas na função ``set``.
			  Se no armazenamento interno elas sofrerem qualquer alteração e for definido
			  ``false`` então elas retornarão seu formato alterado.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public toArray( $originalKeys=false)
	
		.. rst-class:: phpdoc-description
		
			| Retorna toda a coleção atualmente armazenada em um array associativo [ string => mixed ].
			
			| Em caso de uma coleção vazia será retornado ``[]``.
			| 
			| O nome das chaves será sempre o próprio nome do cookie portanto o parametro
			| ``$originalKeys`` não funcionará para esta collection.
			
		
		
		:Parameters:
			- ‹ ?bool › **$originalKeys** |br|
			  

		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $initialValues=[])
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``CookieCollection``.
			
			| Nesta coleção a chave identificadora dos itens da coleção será sempre o mesmo nome de
			| cada cookie indicado.
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores com os quais a instância deve iniciar.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos valores iniciais a serem definidos não seja aceito.
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromString( $str)
	
		.. rst-class:: phpdoc-description
		
			| Utiliza as informações da string indicada para iniciar uma nova coleção de dados.
			
		
		
		:Parameters:
			- ‹ string › **$str** |br|
			  String que será convertida em uma nova coleção.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso a string passada seja inválida para construção de uma nova coleção.
		
	
	

