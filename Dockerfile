FROM phpdockerio/php72-fpm:latest

WORKDIR /application

ADD . /application

RUN composer install

EXPOSE 8080

CMD ["php", "bin/console", "server:run", "0.0.0.0:8080"]
