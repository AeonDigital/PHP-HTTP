.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


FileCollection
==============


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: FileCollection


	.. rst-class:: phpdoc-description
	
		| Coleção que permite agrupar arquivos enviados via ``HTTP``.
		
		| Nesta collection uma mesma chave pode possuir um array de objetos File.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Data\\Abstracts\\aHttpDataCollection`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iFileCollection` 
	

Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $initialValues=[])
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``FileCollection``.
			
		
		
		:Parameters:
			- ‹ ?array › **$initialValues** |br|
			  Valores com os quais a instância deve iniciar.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos valores iniciais a serem definidos não
			  seja aceito.
		
	
	

.. rst-class:: public

	.. php:method:: public dropStreams()
	
		.. rst-class:: phpdoc-description
		
			| Libera todos os ``streams`` da coleção para que eles possam ser utilizados por outra
			| tarefa.
			
			| Após esta ação os métodos das instâncias que dependem diretamente do recurso que foi
			| liberado não irão funcionar.
			
		
		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromString( $str)
	
		.. rst-class:: phpdoc-description
		
			| Utiliza as informações da string indicada para iniciar uma nova coleção de dados.
			
		
		
		:Parameters:
			- ‹ string › **$str** |br|
			  String que será convertida em uma nova coleção.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso a string passada seja inválida para construção de
			  uma nova coleção.
		
	
	

