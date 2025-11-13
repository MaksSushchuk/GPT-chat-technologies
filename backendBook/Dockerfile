FROM php:8.2-cli

# Встановлюємо залежності
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip

# Встановлюємо Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# НІЧОГО не копіюємо сюди - код буде примонтовано як volume

# За замовчуванням запускаємо локальний сервер Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
