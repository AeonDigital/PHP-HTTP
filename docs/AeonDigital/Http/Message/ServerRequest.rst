.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ServerRequest
=============


.. php:namespace:: AeonDigital\Http\Message

.. php:class:: ServerRequest


	.. rst-class:: phpdoc-description
	
		| Encapsula todos os objetos que representam na totalidade uma requisição recebida pelo servidor.
		
		| Instâncias desta classe são consideradas imutáveis; todos os métodos que podem vir a alterar
		| seu estado **DEVEM** ser implementados de forma a manter seu estado e retornar uma nova
		| instância com a alteração necessária para o novo estado.
		| 
		| Implementação AeonDigital da interface ``Psr\Http\Message\ServerRequestInterface``.
		
	
	:Parent:
		:php:class:`AeonDigital\\Http\\Message\\Request`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Message\\iServerRequest` 
	
	:Used traits:
		:php:trait:`AeonDigital\Http\Traits\ParseQualityHeaders` :php:trait:`AeonDigital\Http\Traits\MimeTypeData` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public getNow()
	
		.. rst-class:: phpdoc-description
		
			| Retorna a data e hora do instante em que a instância foi criada.
			
		
		
		:Returns: ‹ \\DateTime ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getServerParams()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os parametros de configuração do servidor para a requisição atual.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getCookieParams()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os cookies enviados pelo ``UA``.
			
			| Será retornado um array associativo contendo chave/valor de cada cookie recebido.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withCookieParams( $cookies)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os objetos ``cookies`` especificado.
			
		
		
		:Parameters:
			- ‹ array › **$cookies** |br|
			  Array associativo de cookies para serem usados pela nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``cookies``.
		
	
	

.. rst-class:: public

	.. php:method:: public getQueryParams()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os querystrings enviados pelo ``UA``.
			
			| Será retornado um array associativo contendo chave/valor de cada querystring recebido.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getQueryString( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor da querystring de nome indicado.
			
			| Retornará ``null`` caso ela não exista.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome da querystring alvo.

		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withQueryParams( $query)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os objetos ``querystrings`` especificado.
			
		
		
		:Parameters:
			- ‹ array › **$query** |br|
			  Array associativo de querystrings para serem usados pela nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``query``.
		
	
	

.. rst-class:: public

	.. php:method:: public getUploadedFiles()
	
		.. rst-class:: phpdoc-description
		
			| Retorna os arquivos enviados pelo ``UA``.
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withUploadedFiles( $uploadedFiles)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os arquivos especificado.
			
		
		
		:Parameters:
			- ‹ array › **$uploadedFiles** |br|
			  Array associativo de arquivos para serem usados pela nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``uploadedFiles``.
		
	
	

.. rst-class:: public

	.. php:method:: public getPostedFields()
	
		.. rst-class:: phpdoc-description
		
			| Retorna um array contendo todos os campos recebidos no corpo da requisição.
			
			| Trata-se de um alias para o método ``getParsedBody``.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPost( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor do campo de nome indicado.
			
			| Retornará ``null`` caso ele não exista.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do campo alvo.

		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getCookie( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor do cookie de nome indicado.
			
			| Retornará ``null`` caso ele não exista.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do cookie alvo.

		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getParam( $name)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor do parametro da requisição de nome indicado.
			
			| A chave é procurada entre Cookies, Attributes, QueryStrings e Post Data respectivamente e
			| será retornada a primeira entre as coleções avaliadas.
			| 
			| Retornará ``null`` caso o nome da chave não seja encontrado.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do campo que está sendo requerido.

		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $httpMethod, $uri, $httpVersion, $headers, $body, $cookies, $queryStrings, $files, $serverParans, $attributes, $bodyParsers=null)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``ServerRequest``.
			
		
		
		:Parameters:
			- ‹ string › **$httpMethod** |br|
			  Método ``HTTP`` que está sendo usado para a requisição.
			- ‹ AeonDigital\\Interfaces\\Http\\Uri\\iUrl › **$uri** |br|
			  Objeto que implementa a interface ``iUrl`` configurado com a ``URI`` que está
			  sendo requisitada pelo ``UA``.
			- ‹ string › **$httpVersion** |br|
			  Versão do protocolo ``HTTP``.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection › **$headers** |br|
			  Objeto que implementa ``iHeaderCollection``
			  cotendo os cabeçalhos da requisição.
			- ‹ AeonDigital\\Interfaces\\Stream\\iStream › **$body** |br|
			  Objeto ``stream`` que faz parte do corpo da mensagem.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection › **$cookies** |br|
			  Objeto que implementa ``iCookieCollection`` cotendo os cookies da requisição.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection › **$queryStrings** |br|
			  Objeto que implementa ``iQueryStringCollection`` cotendo os queryStrings.
			- ‹ AeonDigital\\Interfaces\\Http\\Data\\iFileCollection › **$files** |br|
			  Objeto que implementa ``iFileCollection`` cotendo os arquivos enviados nesta
			  requisição.
			- ‹ array › **$serverParans** |br|
			  Coleção de parametros definidos pelo servidor sobre o ambiente e requisição
			  atual.
			- ‹ AeonDigital\\Interfaces\\Collection\\iCollection › **$attributes** |br|
			  Objeto que implementa ``iCollection`` contendo atributos personalizados para
			  esta requisição.
			- ‹ ?\\AeonDigital\\Interfaces\\Collection\\iCollection › **$bodyParsers** |br|
			  Objeto que implementa ``iCollection`` cotendo os closures que podem efetuar
			  o processamento do body da requisição.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  
		
		:Throws: ‹ \RuntimeException ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getParsedBody()
	
		.. rst-class:: phpdoc-description
		
			| Retorna qualquer parametro enviado no ``body`` da requisição atual
			| em um formato adequado para ser consumido.
			
			| Retornará ``null`` caso nenhum valor tenha sido submetido.
			
		
		
		:Returns: ‹ null | array | object ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withParsedBody( $data)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os arquivos especificado.
			
		
		
		:Parameters:
			- ‹ array › **$data** |br|
			  Array associativo de arquivos para serem usados pela nova instância.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido para ``uploadedFiles``.
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseMimes()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de mimetypes que o ``UA`` definiu como opções válidas para responder
			| a esta requisição.
			
			| Este valor é definido a partir da avaliação qualitativa do Header ``accept``.
			| 
			| Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção de
			| valores válidos.
			| Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
			| ``accept``.
			
		
		
		:Returns: ‹ ?array ›|br|
			  \`\`\` php
			   $arr = [
			       [&#34;mime&#34; => &#34;html&#34;, &#34;mimetype&#34; => &#34;text/html&#34;]
			   ];
			  \`\`\`
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseLocales()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de locales que o ``UA`` definiu como opções válidas para responder
			| a esta requisição.
			
			| Este valor é definido a partir da avaliação qualitativa do Header ``accept-language``.
			| 
			| Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção
			| de valores válidos.
			| Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
			| ``accept-language``.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getResponseLanguages()
	
		.. rst-class:: phpdoc-description
		
			| Retorna uma coleção de languages que o ``UA`` definiu como opções válidos para responder
			| a esta requisição.
			
			| Este valor é definido a partir da avaliação qualitativa do Header ``accept-language``.
			| 
			| Será retornado ``null`` caso não seja possível (por qualquer motivo) definir a coleção de
			| valores válidos.
			| Os valores retornados estarão na ordem de qualificação dos itens encontrados no Header
			| ``accept-language``.
			
		
		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setInitialAttributes( $attributes)
	
		.. rst-class:: phpdoc-description
		
			| Define uma coleção de atributos iniciais para a requisição atual.
			
			| Este método só pode ser utilizado 1 vez.
			| 
			| Estes devem ser **SEMPRE** os primeiros atributos a serem definidos para a coleção.
			
		
		
		:Parameters:
			- ‹ array › **$attributes** |br|
			  Array associativo contendo a coleção de atributos que serão definidos.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAttributes()
	
		.. rst-class:: phpdoc-description
		
			| Coleção de atributos da requisição.
			
			| Os atributos de uma requisição podem ser valores variados como o resultado de uma
			| operação com o caminho requisitado, a decriptação de um cookie, o resultado da
			| desserialização de mensagens recebidas no body, etc.
			| 
			| Diferente das demais propriedades deste tipo de classe, neste caso atributos **SÃO Mutáveis**!
			
		
		
		:Returns: ‹ array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getAttribute( $name, $default=null)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor de um determinado atributo da requisição a partir de seu nome.
			
			| Caso aquele atributo não seja encontrado será retornado o valor definido em ``default``.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  O nome do atributo a ser retornado.
			- ‹ mixed › **$default** |br|
			  Valor padrão para o atributo, caso não exista.

		
		:Returns: ‹ mixed ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public withAttribute( $name, $value)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| contendo os ``attributes`` especificados.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do atributo que será definido.
			- ‹ mixed › **$value** |br|
			  Valor do atributo.

		
		:Returns: ‹ static ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso seja definido um valor inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public withoutAttribute( $name)
	
		.. rst-class:: phpdoc-description
		
			| Este método **DEVE** manter o estado da instância atual e retornar uma nova instância
			| sem o ``attribute`` especificado.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do atributo que será removido.

		
		:Returns: ‹ static ›|br|
			  
		
	
	

