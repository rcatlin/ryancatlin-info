.PHONY: test composer

composer:
	composer install

test: composer
	vendor/bin/phpunit tests --colors --debug --verbose

