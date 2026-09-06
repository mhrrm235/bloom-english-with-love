FROM php:8.2-apache

# Install system dependencies & PHP extensions for Laravel & SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    git \
    curl

RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd zip

# Enable Apache ModRewrite for Laravel routes
RUN a2enmod rewrite

# Configure Apache DocumentRoot to Laravel public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create SQLite database file and set permissions
RUN touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Create entrypoint script with automatic .env creation & key generation
RUN echo '#!/bin/sh\n\
if [ ! -f .env ]; then\n\
  cp .env.example .env\n\
fi\n\
php artisan key:generate --force\n\
touch database/database.sqlite\n\
chown -R www-data:www-data .env database/database.sqlite storage bootstrap/cache\n\
chmod -R 775 storage bootstrap/cache database\n\
php artisan migrate:fresh --seed --force\n\
php artisan storage:link || true\n\
php artisan config:clear\n\
php artisan cache:clear\n\
apache2-foreground' > /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
