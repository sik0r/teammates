FROM php:8.3-fpm-alpine3.19

WORKDIR /var/www/teammates

RUN apk update && apk upgrade

# Install necessary packages
RUN apk add --no-cache \
    postgresql-dev \
    icu-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    mbstring

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
