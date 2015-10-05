.PHONY: test composer cs migrate

composer:
	composer validate
	composer install

cs: composer
    vendor/bin/php-cs-fixer fix --config-file=.php_cs --verbose --diff

test: composer
	vendor/bin/phpunit test --colors --debug --verbose

# See https://github.com/doctrine/DoctrineORMModule/issues/361 as to why '-n' flag is included
migrate:
	./console migrations:migrate -n

