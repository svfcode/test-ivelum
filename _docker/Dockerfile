FROM php:8.1-fpm

COPY ./_docker/php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y  \
    git \
    zlib1g-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install zip

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /usr/src/app
