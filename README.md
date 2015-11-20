# moc-api
API para os aplicativos de MOC (Marcação Online de Cirurgias)

## Dependências
* [PHP](https://www.php.net/)
* [Composer](https://getcomposer.org)
* [Docker](https://www.docker.com/)

## Instalação
1. Clone o repo
2. Instale o [composer](https://getcomposer.org/download/)
3. Configure o [conf/propel.json.default](conf/propel.json.default) com os dados do banco e tire o .default da extensão
4. Rode `composer install`
5. Instale o [docker](http://docs.docker.com/mac/started/)

## Execução
1. Rode `composer create` para criar um novo docker container
2. Rode `composer run` para rodar o servidor no container
3. Acesse o [127.0.0.1:8080](http://127.0.0.1)
4. Rode `composer stop` para parar a execução
