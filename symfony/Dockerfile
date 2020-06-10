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

EXPOSE 9000

COPY docker-entrypoint.sh ${PROJECT_DIR}/

ENTRYPOINT [ "sh", "-c", "${PROJECT_DIR}/docker-entrypoint.sh" ]