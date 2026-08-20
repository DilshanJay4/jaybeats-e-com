# Base Image
FROM php:8.1-apache

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Working Directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set ownership and permissions for web server upload directory
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/uploaded_img

# Expose HTTP port
EXPOSE 80
