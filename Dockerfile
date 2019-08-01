FROM mysql:5.7
FROM php:7.3.0-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update
RUN apt-get install -y git libzip-dev unzip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite headers

COPY . /var/www
WORKDIR /var/www/app
RUN composer install
# app -> "composer install" 

RUN service apache2 restart