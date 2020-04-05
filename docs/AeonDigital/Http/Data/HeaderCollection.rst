.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


HeaderCollection
================


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: HeaderCollection


	.. rst-class:: phpdoc-description
	
		| Coleção que permite agrupar Headers ``HTTP``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Data\\Abstracts\\aHttpDataCollection`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection` :php:interface:`AeonDigital\\Interfaces\\Collection\\iCaseInsensitiveCollection` 
	

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
			| Prioriza o retorno das chaves conforme usadas internamente pois considera que se há uma
			| alteração nelas deve-se a alguma importância relacionado a seu formato de uso.
			
		
		
		:Parameters:
			- ‹ ?bool › **$originalKeys** |br|
			  Quando ``true`` irá usar as chaves conforme foram definidas na função ``set``.
			  Se no armazenamento interno elas sofrerem qualquer alteração e for definido
			  ``false`` então elas retornarão seu formato alterado.

		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $initialValues=[])
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``HeaderCollection``.
			
			| Cada entrada corresponde a um array de valores conforme o modelo:
			| 
			| \`\`\`
			|  header => string[];
			| \`\`\`
			
		
		
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
		
	
	

.. rst-class:: public

	.. php:method:: public getHeaderLine( $key)
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma string representando toda a coleção de valores determinados para o header
			| de nome indicado. Cada valor é separado por virgula.
			
			| Uma string vazia será retornada caso o header não exista.
			
		
		
		:Parameters:
			- ‹ string › **$key** |br|
			  Nome do header alvo.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

