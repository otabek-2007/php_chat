FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    autoconf \
    g++ \
    make \
    pcre-dev \
    libtool \
    postgresql-dev

RUN docker-php-ext-install pgsql && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install zip && \
    docker-php-ext-install exif && \
    docker-php-ext-install gd && \
    docker-php-ext-install sockets

RUN pecl install redis && \
    docker-php-ext-enable redis && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www/chat