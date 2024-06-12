# Use the official PHP image as a base image
FROM php:7.4-apache

# Copy the application files to the default web directory in the container
COPY index.php  /var/www/html/

# Set appropriate permissions for the web root
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80
