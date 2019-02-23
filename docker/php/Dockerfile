FROM php:7.2.0-fpm

RUN apt-get update && apt-get install zlib1g-dev -y \
            libmcrypt-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        supervisor \
        git zip \
    && docker-php-ext-install -j$(nproc) pdo \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) pdo_mysql

RUN curl -sS https://getcomposer.org/installer | \
php -- --install-dir=/usr/bin/ --filename=composer
