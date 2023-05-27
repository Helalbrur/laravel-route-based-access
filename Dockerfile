# Use the official PHP image as the base image
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json and composer.lock files to the container
COPY composer.json composer.lock ./

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application code to the container
COPY . .

# Generate the autoload files
RUN composer dump-autoload --optimize

# Copy the Apache virtual host configuration file
COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Set the document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Check the minimum PHP requirement from composer.json
RUN php -r "if (version_compare(PHP_VERSION, '8.1.0', '<')) { echo 'Your PHP version is not supported. Please use PHP >= 8.1.0.'; exit(1); }"

# Install JavaScript dependencies
RUN npm install

# Build assets
RUN npm run production

# Set the correct permissions for storage and bootstrap/cache folders
RUN chown -R www-data:www-data storage bootstrap/cache

# Generate the application key
RUN php artisan key:generate

# Run database migrations and seed the database
RUN php artisan migrate --seed

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
