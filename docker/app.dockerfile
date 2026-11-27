FROM composer:2 AS composer

FROM php:8.5.12-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql sockets \
    && a2enmod rewrite \
    && sed -ri 's!/var/www/html!/var/www/laravel/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel

COPY composer.json ./

RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["sh", "-c", "if [ ! -f .env ]; then cp .env.example .env && php artisan key:generate; fi; exec apache2-foreground"]
