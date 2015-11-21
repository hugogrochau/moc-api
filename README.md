# moc-api
API para os aplicativos de MOC (Marcação Online de Cirurgias)

## Dependencies
* [PHP](https://www.php.net/)
* [Composer](https://getcomposer.org)
* [Docker](https://www.docker.com/)

## Installing
1. Clone this repo
2. Install [composer](https://getcomposer.org/download/)
3. Configure [conf/propel.json.default](conf/propel.json.default) with the db information and remove the .default
extension
4. Run `composer install`
5. Install [docker](http://docs.docker.com/mac/started/)

## Running
1. Run `composer create` to create a docker container
2. Run `composer run` to run the server within the container
3. Open [127.0.0.1:8080](http://127.0.0.1)
4. Run `composer stop` to stop the server

## Other Commands
### Propel
* `composer build-schema` to generate a schema from a database (requires propel.json configuration)
* `composer build-models` to build propel models from schema
* `composer generate-config` to generate `conf/config.php` from `conf/propel.json`

### Testing
* `composer test` to run all tests

### Docker
* `composer remove-containers` to remove all related docker containers


## Stack
* [Slim 3](http://www.slimframework.com/) for routing/middleware/services [(docs)](http://www.slimframework.com/docs/)
* [Propel](http://propelorm.org/) ORM [(docs)](http://propelorm.org/documentation/)
* [Redis](http://redis.io/) for caching
* [PHPUnit](https://phpunit.de/) for testing
