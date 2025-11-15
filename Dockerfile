FROM php:8.3-cli

# System deps
RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libssl-dev pkg-config libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP MongoDB driver
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps first to leverage Docker layer cache
COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist --no-dev || true

# App source
COPY . .

# Ensure storage bootstrap perms (optional for local dev)
RUN chmod -R a+w storage bootstrap/cache || true

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
