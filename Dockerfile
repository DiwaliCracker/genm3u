# Use the official PHP image from Docker Hub
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Copy all files from your local directory to the container
COPY . /var/www/html

# Install dependencies (if any) and enable necessary PHP extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable mod_rewrite for Apache (if necessary for your app)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
