.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


MimeTypeData
============


.. php:namespace:: AeonDigital\Http\Traits

.. php:trait:: MimeTypeData


	.. rst-class:: phpdoc-description
	
		| Fornece métodos relacionados a identificação e uso de ``mimetypes``.
		
	

Properties
----------

Methods
-------

.. rst-class:: public

	.. php:method:: public retrieveFileMimeType( $fileName)
	
		.. rst-class:: phpdoc-description
		
			| A partir da extenção do arquivo indicado identifica seu ``mimetype`` correspondente.
			
			| Retornará ``application/octet-stream`` caso não seja possível identificar o tipo
			| correspondente.
			
		
		
		:Parameters:
			- ‹ string › **$fileName** |br|
			  Nome do arquivo que se deseja obter o ``mimetype``.

		
		:Returns: ‹ string ›|br|
			  
		
	
	

