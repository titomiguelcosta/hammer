HAMMER
======

With gobie and check runs on... one moiiiiaaaaire

API by developers for developers
--------------------------------

Hammer is an API that exposes services that developers normally use so they can build a mobile app or website on top of it. 

For now it integrates with:

* GitHub
* Twitter
* LinkedIn

## Installation

Copy the .env to .env.local and add configuration for the services you want to use.

* [GitHub](https://help.github.com/articles/creating-a-personal-access-token-for-the-command-line/)
* [Twitter](https://apps.twitter.com/)
* [LinkedIn](https://www.linkedin.com/developer/apps) 

## Development

The API is powered by Symfony 4 and it only needs a server running PHP 7.2 and a database (MySQL/SQLite).

Configuration for Docker is provided. To develop locally, just run:

$ docker-compose up

## Endpoints

It is a read-only API. All the endpoints return JSON and just proxy the original API responses.

It uses Nelmio API Docs, check /v1/docs.

### Libraries

* [GitHub](https://github.com/KnpLabs/php-github-api)
* [Twitter](https://github.com/abraham/twitteroauth)
* [LinkedIn](https://github.com/zoonman/linkedin-api-php-client)

## Deployment

Configuration was added to deploy to [AWS ElasticBeanstalk](https://docs.aws.amazon.com/elasticbeanstalk). 

Make sure you have the command [eb](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3.html) available. Tested with: EB CLI 3.14.3, aws-cli/1.15.20 (Python 3.6.1).

* pip install -r requirements.txt
* aws configure --profile hammer

* aws ec2 create-key-pair --profile hammer --key-name=hammer --query 'KeyMaterial' --output text > ~/.ssh/hammer.pem
* chmod 400 ~/.ssh/hammer.pem

Create certificate, check your e-mail and validate before proceeding, and edit .ebextensions/00-custom.config with the certificate ARN
* aws acm request-certificate --profile hammer --domain-name titodevops.com --idempotency-token=frgasaseae3e2da --subject-alternative-names *.titodevops.com

* php composer.phar install
* make build

* Init project: eb init hammer --profile hammer --quiet 
* Create an environment: eb create development
* Configure environment variables: eb setenv APP_NAME=hammer *NAME*=*VALUE* ...
* Deploy a new version: eb deploy development

## Resources

* https://aws.amazon.com/blogs/devops/using-the-elastic-beanstalk-eb-cli-to-create-manage-and-share-environment-configuration/
