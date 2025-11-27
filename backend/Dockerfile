# Base image PHP 8.4
FROM php:8.4-cli

# Install system dependencies, PHP extensions, cleanup
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Set permissions for Composer Cache
RUN mkdir -p /var/www/.composer/cache && \
    chown -R www-data:www-data /var/www/.composer

# Set permissions
RUN mkdir -p vendor storage bootstrap/cache && \
    chown -R www-data:www-data vendor storage bootstrap/cache && \
    chmod -R 775 vendor storage bootstrap/cache

# Set user
USER www-data

# Expose port
EXPOSE 8084