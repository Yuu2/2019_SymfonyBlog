FROM php:fpm-stretch

RUN apt-get update && apt-get install -y

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        vim \
        libicu-dev \
        zlib1g-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        zip \
        intl \
        mysqli \
        pdo pdo_mysql

RUN  curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer

ENV  COMPOSER_ALLOW_SUPERUSER 1

COPY composer.json        /var/www/portfolio_blog/
COPY composer.lock        /var/www/portfolio_blog/

COPY symfony.sh /usr/local/bin/

RUN chmod +x /usr/local/bin/symfony.sh

EXPOSE 9000

ENTRYPOINT [ "sh", "/usr/local/bin/symfony.sh" ]