build:
	zip -r project.zip bin/ config/ public/ src/ templates/ vendor/ composer.json composer.lock composer.phar .ebextensions/ .elasticbeanstalk/

publish:
	eb deploy --staged