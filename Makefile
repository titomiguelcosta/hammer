build:
	zip -r project.zip bin/ config/ public/ src/ vendor/ composer.json composer.lock composer.phar .ebextensions/ .elasticbeanstalk/ .env

publish:
	eb deploy --staged
