PHP-Http
=========

> [Aeon Digital](http://www.aeondigital.com.br)
>
> rianna@aeondigital.com.br

&nbsp;

Implementações das interfaces **Psr/Http/Message{...}**.


&nbsp;
&nbsp;


________________________________________________________________________________________________________________________

## Instalação

Instale em seu projeto usando o composer:
**Via terminal**
```shell
  composer require aeondigital/phphttp
```

**Via composer.json**
```json
"require": {
    "aeondigital/phphttp": "dev-main"
}
```


&nbsp;
&nbsp;


________________________________________________________________________________________________________________________

## Shell-Make

Instale também o módulo ``Shell-Make`` para ter acesso a macros que auxiliam no desenvolvimento individual deste
projeto. Use os comandos abaixo:

```shell
  git submodule init
  git submodule update --remote
```

Após a instalação instalar, crie/edite o ``Makefile`` na raiz do seu projeto adicionando o seguinte:

```Makefile
  include Shell-Make/Makefile
```

Conheça os macros disponíveis pelo ``Shell-Make`` use o seguinte comando:

```shell
  make help
```


&nbsp;
&nbsp;


________________________________________________________________________________________________________________________

## Outras Informações

Este e outros projetos **Aeon Digital** utilizam o sistema de [Versionamento Semântico](https://semver.org/) proposto 
por Tom Preston-Werner.


&nbsp;
&nbsp;


________________________________________________________________________________________________________________________

## Licença

Este software está licenciado sob a [Licença MIT](LICENSE).
