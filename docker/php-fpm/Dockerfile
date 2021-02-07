FROM php:7.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        git curl wget \
        libmemcached-dev libmcrypt-dev libxml2-dev \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev zlib1g-dev libicu-dev g++ \
        libpq-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install xml pcntl \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

ENV REDIS_VERSION 4.0.2

RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/$REDIS_VERSION.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-* /usr/src/php/ext/redis

RUN docker-php-ext-install redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
