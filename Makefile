.PHONY: test composer cs migrate setup

# For setting up the dev environment.
setup:
	cp .env.dist .env

composer:
	composer validate
	composer install

cs: composer
    vendor/bin/php-cs-fixer fix --config-file=.php_cs --verbose --diff

database:
	mysql -uroot -e "DROP DATABASE IF EXISTS ryancatlin_info_test; CREATE DATABASE ryancatlin_info_test"
	make migrate

test: composer
	vendor/bin/phpunit test --colors --debug --verbose

# See https://github.com/doctrine/DoctrineORMModule/issues/361 as to why '-n' flag is included
migrate:
	./console migrations:migrate -n

