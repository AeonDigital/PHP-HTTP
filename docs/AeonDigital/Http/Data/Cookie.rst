.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Cookie
======


.. php:namespace:: AeonDigital\Http\Data

.. php:class:: Cookie


	.. rst-class:: phpdoc-description
	
		| Representa um cookie.
		
	
	:Parent:
		:php:class:`AeonDigital\\BObject`
	
	:Implements:
		:php:interface:`AeonDigital\\Interfaces\\Http\\Data\\iCookie` 
	
	:Used traits:
		:php:trait:`AeonDigital\Traits\MainCheckArgumentException` 
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public setName( $name)
	
		.. rst-class:: phpdoc-description
		
			| Define o nome do cookie.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do cookie.

		
		:Returns: ‹ void ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso o valor indicado seja inválido.
		
	
	

.. rst-class:: public

	.. php:method:: public getName()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o nome identificador do cookie.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setValue( $value)
	
		.. rst-class:: phpdoc-description
		
			| Define o valor do cookie.
			
			| O valor será armazenado em ``percent-encode``.
			
		
		
		:Parameters:
			- ‹ string › **$value** |br|
			  Valor do cookie.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getValue( $urldecoded=true)
	
		.. rst-class:: phpdoc-description
		
			| Retorna o valor do cookie.
			
			| O valor será retornado usando ``percent-encode``.
			
		
		
		:Parameters:
			- ‹ bool › **$urldecoded** |br|
			  Indica se o valor retornado deve ser convertido para o formato **natural**,
			  sem ``percent-encode``.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setExpires( $expires)
	
		.. rst-class:: phpdoc-description
		
			| Define o ``Expires`` do cookie.
			
			| O valor ``null`` irá remover esta propriedade do cookie.
			
		
		
		:Parameters:
			- ‹ ?\\AeonDigital\\Http\\Data\\DateTime › **$expires** |br|
			  Data de expiração.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getExpires()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o atual valor de ``Expires`` definido para este cookie em formato \DateTime.
			
			| O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
			
		
		
		:Returns: ‹ ?\\AeonDigital\\Http\\Data\\DateTime ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getStrExpires()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o atual valor de ``Expires`` definido para este cookie.
			
			| O valor deve ser devolvido usando o modelo:
			| 
			| \`\`\`
			|  strDay(3 char), intDay strMonth(3 char) intYear intHour:intMinute:intSec UTC
			| \`\`\`
			| 
			| O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
			
		
		
		:Returns: ‹ ?\\DateTime ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setDomain( $domain)
	
		.. rst-class:: phpdoc-description
		
			| Define o ``Domain`` do cookie.
			
			| O valor ``null`` irá remover esta propriedade do cookie.
			
		
		
		:Parameters:
			- ‹ ?string › **$domain** |br|
			  Domain.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getDomain()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o ``Domain`` definido para este cookie.
			
			| O velor deve ser devolvido em seu formato ``lowerCase``.
			| 
			| O valor ``null`` será retornado caso nenhum valor esteja definido para esta propriedade.
			
		
		
		:Returns: ‹ ?string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setPath( $path)
	
		.. rst-class:: phpdoc-description
		
			| Define o ``Path`` do cookie.
			
			| O valor ``null`` irá remover esta propriedade do cookie.
			
		
		
		:Parameters:
			- ‹ ?string › **$path** |br|
			  Path.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getPath()
	
		.. rst-class:: phpdoc-description
		
			| Retorna o ``Path`` definido para este cookie.
			
			| O valor ``/`` será retornado caso nenhum valor esteja definido para esta propriedade.
			
		
		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setSecure( $secure)
	
		.. rst-class:: phpdoc-description
		
			| Define se o cookie é do tipo ``Secure``.
			
			| Quando ``true`` significa que o cookie só deve trafegar em canais seguros (tipicamente
			| ``HTTP`` sobre uma camada TSL).
			| 
			| O valor ``null`` irá remover esta propriedade do cookie.
			
		
		
		:Parameters:
			- ‹ bool › **$secure** |br|
			  Secure.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getSecure()
	
		.. rst-class:: phpdoc-description
		
			| Indica se a diretiva ``Secure`` deve ser aplicada.
			
			| Quando ``true`` significa que o cookie só deve trafegar em canais seguros (tipicamente
			| ``HTTP`` sobre uma camada TSL).
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public setHttpOnly( $httpOnly)
	
		.. rst-class:: phpdoc-description
		
			| Define se o cookie é do tipo ``HttpOnly``.
			
			| Quando ``true`` significa que o cookie só deve trafegar em via ``HTTP``.
			| 
			| O valor ``null`` irá remover esta propriedade do cookie.
			
		
		
		:Parameters:
			- ‹ bool › **$httpOnly** |br|
			  HttpOnly.

		
		:Returns: ‹ void ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public getHttpOnly()
	
		.. rst-class:: phpdoc-description
		
			| Indica se a diretiva ``HttpOnly`` deve ser aplicada.
			
			| Quando ``true`` significa que o cookie só deve trafegar em via ``HTTP``.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public __construct( $name, $value=&#34;&#34;, $expires=null, $domain=null, $path=&#34;/&#34;, $secure=false, $httpOnly=false)
	
		.. rst-class:: phpdoc-description
		
			| Inicia um novo objeto ``Cookie``.
			
		
		
		:Parameters:
			- ‹ string › **$name** |br|
			  Nome do cookie.
			- ‹ string › **$value** |br|
			  Valor do cookie.
			- ‹ ?\\DateTime › **$expires** |br|
			  Data de expiração do cookie.
			- ‹ ?string › **$domain** |br|
			  Domínio.
			- ‹ ?string › **$path** |br|
			  Path.
			- ‹ bool › **$secure** |br|
			  Secure.
			- ‹ bool › **$httpOnly** |br|
			  HttpOnly.

		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Caso algum dos valores iniciais a serem definidos não
			  seja aceito.
		
	
	

.. rst-class:: public

	.. php:method:: public toString( $urldecoded=true)
	
		.. rst-class:: phpdoc-description
		
			| Devolve uma string com o valor completo do Cookie.
			
			| \`\`\`
			|  name=value; [Expires=string;] [Domain=string;] [Path=string;] [Secure;] [HttpOnly;]
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ bool › **$urldecoded** |br|
			  Indica se o valor retornado deve ser convertido para o formato **natural**,
			  sem ``percent-encode``.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public defineCookie()
	
		.. rst-class:: phpdoc-description
		
			| Cria o cookie e envia-o para o ``UA``.
			
			| O retorno ``true`` apenas indica que a operação foi concluída mas não que o ``UA``
			| aceitou o Cookie.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public removeCookie()
	
		.. rst-class:: phpdoc-description
		
			| Remove o cookie atual.
			
			| O retorno ``true`` apenas indica que a operação foi concluída mas não que o ``UA``
			| aceitou o Cookie.
			
		
		
		:Returns: ‹ bool ›|br|
			  
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromString( $str)
	
		.. rst-class:: phpdoc-description
		
			| Converte a string passada em um objeto Cookie.
			
		
		
		:Parameters:
			- ‹ string › **$str** |br|
			  String do objeto Cookie.

		
		:Returns: ‹ \\AeonDigital\\Http\\Data\\Cookie ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Se a conversão não for possível.
		
	
	

.. rst-class:: public static

	.. php:method:: public static fromRawCookieHeader( $str)
	
		.. rst-class:: phpdoc-description
		
			| Converte uma string de dados brutos em um array de cookies correspondendo às informações
			| existentes para cada qual.
			
			| Retorna um array associativo onde:
			| 
			| \`\`\`
			|  [&#34;cookieName&#34; => Cookie ]
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ string › **$str** |br|
			  String dos objetos Cookie.

		
		:Returns: ‹ array ›|br|
			  
		
		:Throws: ‹ \InvalidArgumentException ›|br|
			  Se a conversão não for possível.
		
	
	

