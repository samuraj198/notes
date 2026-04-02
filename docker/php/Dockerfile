FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY /src .

RUN composer install

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache