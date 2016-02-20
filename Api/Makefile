.PHONY: test composer cs migrate setup database test unit integration

# For setting up the dev environment.
setup:
	cp config/.env.dist config/.env

composer:
	composer validate
	composer install

cs: composer
    vendor/bin/php-cs-fixer fix --config-file=.php_cs --verbose --diff

database:
	mysql -uroot -e "DROP DATABASE IF EXISTS ryancatlin_info_test; CREATE DATABASE ryancatlin_info_test"
	make migrate

test: composer setup unit integration

unit: database
	vendor/bin/phpunit test/Unit --colors --debug --verbose

integration: database
	./script/integration.sh

validate:
	./script/console orm:validate-schema

dev-server:
	cd web && node app.js

# See https://github.com/doctrine/DoctrineORMModule/issues/361 as to why '-n' flag is included
migrate:
	./script/console migrations:migrate -n

