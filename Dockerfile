FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_sqlite mbstring exif

WORKDIR /var/www/html

COPY . .

RUN composer install

COPY .env.example .env

RUN touch database/database.sqlite

RUN php artisan key:generate

RUN php artisan migrate

EXPOSE 8000

CMD ["php", "artisan", "serve"]
