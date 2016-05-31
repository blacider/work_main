help:
	@echo install-php-deps

COMPOSER = php composer.phar

install-php-deps:
	@${COMPOSER} install

