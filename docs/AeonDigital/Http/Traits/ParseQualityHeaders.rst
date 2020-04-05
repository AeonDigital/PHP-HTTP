.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ParseQualityHeaders
===================


.. php:namespace:: AeonDigital\Http\Traits

.. php:trait:: ParseQualityHeaders


	.. rst-class:: phpdoc-description
	
		| Fornece métodos relacionados a verificação qualitativa dos ``headers`` que utilizam indicativos
		| de qualificação.
		
	

Methods
-------

.. rst-class:: public

	.. php:method:: public parseArrayOfQualityHeaders( $headers)
	
		.. rst-class:: phpdoc-description
		
			| Trata os valores de ``headers`` marcados com parametros **quality** que identificam a
			| preferência de algum tipo de conteúdo ou comportamento sobre outro.
			
			| Retorna um ``array`` ordenado dos dados encontrados em ordem de preferência.
			| Valores em igual nível de preferência serão retornados alfabeticamente.
			| 
			| \`\`\` php
			|      $headers = [
			|          &#34;text/html&#34;,
			|          &#34;application/xhtml+xml&#34;,
			|          &#34;application/xml;q=0.9&#34;,
			|          &#34;* /*;q=0.8&#34;
			|      ];
			| 
			|      $return = [
			|          // string   &#34;value&#34;     Valor real.
			|          // float    &#34;quality&#34;   Nível da &#34;qualidade&#34; atribuido.
			|          [&#34;value&#34; => &#34;text/html&#34;, &#34;quality&#34; => 1],
			|          [&#34;value&#34; => &#34;application/xhtml+xml&#34;, &#34;quality&#34; => 1],
			|          [&#34;value&#34; => &#34;application/xml&#34;, &#34;quality&#34; => 0.9],
			|          [&#34;value&#34; => &#34;* /*&#34;, &#34;quality&#34; => 0.8]
			|      ];
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ ?array › **$headers** |br|
			  Valores do header em formato de ``array``.

		
		:Returns: ‹ ?array ›|br|
			  O objeto de retorno é um **array de arrays associativos** conforme
			  exemplificado acima.
		
	
	

.. rst-class:: public

	.. php:method:: public parseRawLineOfQualityHeaders( $headers)
	
		.. rst-class:: phpdoc-description
		
			| Trata os valores brutos de ``headers`` marcados com parametros **quality** que identificam a
			| preferência de algum tipo de conteúdo ou comportamento sobre outro.
			
			| Retorna um ``array`` ordenado dos dados encontrados em ordem de preferência.
			| Valores em igual nível de preferência serão retornados alfabeticamente.
			| 
			| \`\`\` php
			|      $headers = &#34;text/html,application/xhtml+xml,application/xml;q=0.9,* /*;q=0.8&#34;;
			| 
			|      $return = [
			|          // string   &#34;value&#34;     Valor real.
			|          // float    &#34;quality&#34;   Nível da &#34;qualidade&#34; atribuido.
			|          [&#34;value&#34; => &#34;text/html&#34;, &#34;quality&#34; => 1],
			|          [&#34;value&#34; => &#34;application/xhtml+xml&#34;, &#34;quality&#34; => 1],
			|          [&#34;value&#34; => &#34;application/xml&#34;, &#34;quality&#34; => 0.9],
			|          [&#34;value&#34; => &#34;* /*&#34;, &#34;quality&#34; => 0.8]
			|      ];
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ ?string › **$headers** |br|
			  Versão bruta do ``header``.

		
		:Returns: ‹ ?array ›|br|
			  O objeto de retorno é um **array de arrays associativos** conforme
			  exemplificado acima.
		
	
	

.. rst-class:: public

	.. php:method:: public parseArrayOfHeaderAcceptLanguage( $headers)
	
		.. rst-class:: phpdoc-description
		
			| Trata o valor bruto de um header ``AcceptLanguage`` e retorna um ``array``.
			
			| Retornará um ``array`` associativo contendo 2 chaves, **locales** e **languages** sendo
			| cada uma um ``array`` trazendo aquela informação em ordem de prioridade.
			| 
			| Os valores serão retornados todos em ``lowercase``.
			| 
			| \`\`\` php
			|      $headers = [
			|          &#34;pt-BR&#34;,
			|          &#34;pt;q=0.8&#34;,
			|          &#34;en-US;q=0.5&#34;,
			|          &#34;en;q=0.3&#34;
			|      ];
			| 
			|      $return = [
			|          // string[]   &#34;locales&#34;       Coleção de locales aceitos.
			|          // string[]   &#34;languages&#34;     Coleção de linguagens aceitas.
			|          &#34;locales&#34; => [&#34;pt-br&#34;, &#34;en-us&#34;],
			|          &#34;languages&#34; => [&#34;pt&#34;, &#34;en&#34;],
			|      ];
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ ?array › **$headers** |br|
			  Valores do ``header`` em formato de ``array``.

		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

.. rst-class:: public

	.. php:method:: public parseRawLineOfHeaderAcceptLanguage( $headers)
	
		.. rst-class:: phpdoc-description
		
			| Trata o valor bruto de um ``header AcceptLanguage`` e retorna um ``array``.
			
			| Retornará um ``Array Associativo`` contendo 2 chaves, **locales** e **languages** sendo
			| cada uma um ``array`` trazendo aquela informação em ordem de prioridade.
			| 
			| Os valores serão retornados todos em ``lowercase``.
			| 
			| \`\`\` php
			|      $headers = &#34;pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3&#34;;
			| 
			|      $return = [
			|          // string[]   &#34;locales&#34;       Coleção de locales aceitos.
			|          // string[]   &#34;languages&#34;     Coleção de linguagens aceitas.
			|          &#34;locales&#34; => [&#34;pt-br&#34;, &#34;en-us&#34;],
			|          &#34;languages&#34; => [&#34;pt&#34;, &#34;en&#34;],
			|      ];
			| \`\`\`
			
		
		
		:Parameters:
			- ‹ ?string › **$headers** |br|
			  Versão bruta do ``header``.

		
		:Returns: ‹ ?array ›|br|
			  
		
	
	

