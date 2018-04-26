HAMMER
======

API by developers for developers
--------------------------------

Hammer is an API that exposes services that developers normally use so they can build a mobile app or website on top of it. 

For now it integrates with:

* GitHub
* Twitter
* LinkedIn

## Installation

Copy the .env.dist to .env and add configuration for the services you want to use.

* [GitHub](https://help.github.com/articles/creating-a-personal-access-token-for-the-command-line/)
* [Twitter](https://apps.twitter.com/)
* [LinkedIn](https://www.linkedin.com/developer/apps) 

## Development

The API is powered by Symfony 4 and it only needs a server running PHP 7 and a database (MySQL/SQLite).

Configuration for Docker is provided. To develop locally, just run:

$ docker-compose up

### Libraries

* [GitHub](https://github.com/KnpLabs/php-github-api)
* [Twitter](https://github.com/abraham/twitteroauth)
* [LinkedIn](https://github.com/zoonman/linkedin-api-php-client)

## Deployment

Configuration was added to deploy to AWS ElasticBeanstalk. 

Make sure you have the command [eb](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3.html) available. Tested with: EB CLI 3.12.4 (Python 3.6.1).

* Create an environment: eb create *ENV*
* Configure environment variables: eb setenv APP_NAME=DEV *NAME*=*VALUE* ...
* Deploy a new version: eb deploy *ENV*