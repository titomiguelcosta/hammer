SHELL := /bin/bash

build:
	(rm project.zip || true) \
	&& zip -r project.zip bin/ config/ public/ src/ templates/ vendor/ composer.json composer.lock composer.phar .ebextensions/ .elasticbeanstalk/

publish:
	eb deploy --staged

fix:
	php vendor/bin/php-cs-fixer fix src/
