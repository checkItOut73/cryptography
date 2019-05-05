FROM php:7.1.8-apache

COPY build/configs/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY build/configs/apt.sources.list /etc/apt/sources.list

RUN chown www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && apt-get update -y \

    # install xdebug
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \

    # install gmp
    && apt-get install -y libgmp-dev \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install gmp
