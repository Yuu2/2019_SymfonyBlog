FROM php:7.4.0-apache

RUN apt-get update
RUN apt-get install -y git libzip-dev unzip vim \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite headers

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/app
WORKDIR /var/www/app/

RUN composer install

RUN service apache2 restart