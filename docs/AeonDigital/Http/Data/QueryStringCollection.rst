.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


QueryStringCollection
=====================


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: QueryStringCollection


	.. rst-class:: phpdoc-description
	
		| Coleção que permite agrupar QueryStrings.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Data\\Abstracts\\aHttpDataCollection`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection` 
	

Properties
----------

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

	.. php:method:: public __construct( $initialValues=[])
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``QueryStringCollection``.
			
			| Cada entrada corresponde a um array de valores conforme o modelo:
			| 
			| \`\`\`
			|  querystring => string
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores com os quais a instância deve iniciar.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos valores iniciais a serem definidos não seja aceito.
		
	
	

.. rst-class:: public

	.. php:method:: public usePercentEncode( $use)
	
		.. rst-class:: phpdoc-description
		
			| Permite determinar quando os valores retornados pela coleção devem ou não estar usando
			| ``percent-encode``.
			
			| Internamente os valores devem **SEMPRE** serem armazenados utilizando tal encode, mas ao
			| retornar os dados eles devem ser alterados caso seja definido ``false``.
			
		
		
		:Parameters:
			- ‹ bool › **$use** |br|
			  Indica se a coleção deve retornar os valores utilizando ``percent-encode`` ou não.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public get( $key)
	
		.. rst-class:: phpdoc-description
		
			| Resgata um valor da coleção a partir do nome da chave indicada.
			
		
		
		:Parameters:
			- ‹ string › **$key** |br|
			  Nome da chave cujo valor deve ser retornado.

		
		:Returns: ‹ mixed | null ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso a regra da classe concreta defina que em caso de ser passado uma chave
			  inexistente seja lançada uma exception.
		
	
	

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
		
	
	

