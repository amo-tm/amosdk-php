FROM php:7.4-cli
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN apt-get update && \
    apt-get install -y libzip-dev && \
    docker-php-ext-install zip