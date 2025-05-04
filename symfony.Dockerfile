# Use official PHP 8.2 with FPM (recommended for Symfony)
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    opcache \
    zip

# Install Node.js (for Symfony Encore/Webpack)
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install Composer (from official Composer image)
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy only composer files first (for better caching)
COPY ./tp6_symfony-main/composer.* ./

# Install PHP dependencies (without autoloader for now)
RUN composer install --no-autoloader --no-scripts --no-interaction

# Copy the rest of the Symfony app
COPY ./tp6_symfony-main .

# Generate optimized autoloader & run Symfony scripts
RUN composer dump-autoload --optimize && composer run-script post-install-cmd

# Fix file permissions (important for Symfony cache)
RUN chown -R www-data:www-data /var/www

# Expose port 9000 (PHP-FPM default) or 8000 (PHP dev server)
EXPOSE 8000

# Start PHP built-in server (for development)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]