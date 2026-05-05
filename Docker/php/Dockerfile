# docker/php/Dockerfile
FROM php:8.2-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache

RUN chown -R www-data:www-data /var/www/html/storage