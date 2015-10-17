.PHONY: test composer

composer:
	composer install

test: composer
	vendor/bin/phpunit test --colors --debug --verbose

