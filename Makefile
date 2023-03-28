init: vendor serve

update:
	make COMMAND=update _composer
install: vendor
vendor:
	make COMMAND=install _composer
_composer:
	composer ${COMMAND}
	cd demo && composer ${COMMAND}
	@for PACKAGE in packages/*; do composer -d $$PACKAGE ${COMMAND}; done

serve:
	@PHP_IDE_CONFIG="serverName=localhost" php demo/web

check: vendor fix test
fix:
	@php vendor/bin/phpcbf --standard=PSR12 --extensions=php packages/*/src demo/src
test:
	@php vendor/bin/phpcs --standard=PSR12 --extensions=php packages/*/src demo/src
	@make phpstan

phpstan:
ifdef PACKAGE
	php vendor/bin/phpstan analyse --autoload-file packages/${PACKAGE}/vendor/autoload.php packages/${PACKAGE}/src
else
	@php vendor/bin/phpstan analyse --autoload-file demo/vendor/autoload.php --level 5 demo/src
	@for PACKAGE in packages/*; do php vendor/bin/phpstan analyse --autoload-file $$PACKAGE/vendor/autoload.php $$PACKAGE/src; done
endif
