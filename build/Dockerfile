FROM php:7.1.8-apache

COPY build/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN chown www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
