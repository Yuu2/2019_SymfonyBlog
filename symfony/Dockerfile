FROM php:fpm-stretch

ARG APP
ARG APP_VIRTUAL

ENV APP ${APP}
ENV APP_VIRTUAL ${APP_VIRTUAL}

RUN apt-get update && apt-get install -y --no-install-recommends \
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

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer

EXPOSE 9000

WORKDIR ${APP_VIRTUAL}

COPY ${APP}/docker-entrypoint.sh .

ENTRYPOINT [ "sh", "-c", "./docker-entrypoint.sh" ]