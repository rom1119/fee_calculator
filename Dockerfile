# Basisimage
FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev

RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip

WORKDIR /app

COPY ./app /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


