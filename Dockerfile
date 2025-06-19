# Use the official PHP image with required extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd pdo_sqlite

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy package files first to leverage Docker cache
COPY package*.json ./
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install --legacy-peer-deps

# Copy the rest of the application
COPY . .

# Build assets
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads

# Expose port 8080 and start php-fpm server
EXPOSE 8080

# Start Laravel's built-in server, ensuring SQLite file exists
CMD ["/bin/sh", "-c", "mkdir -p /data && touch /data/database.sqlite && php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8080"] 