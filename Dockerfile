# Start from an official PHP image
FROM php:8.2-fpm-alpine

# Install system dependencies needed for MongoDB extension
RUN apk add --no-cache autoconf build-base

# Install the MongoDB PHP extension using PECL
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

WORKDIR /app
COPY . /app

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 8000 for your app
EXPOSE 8000

# Start your application (example for Laravel)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
