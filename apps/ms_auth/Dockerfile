FROM php:8.2-fpm

RUN apt-get update && apt-get install git libicu-dev libzip-dev libgmp-dev unzip libxml2-dev iputils-ping --no-install-recommends -y \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mysqli pdo pdo_mysql zip xml bcmath gmp \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && pecl install -f redis \
    && pecl install pcov && docker-php-ext-enable pcov \
    && docker-php-ext-enable redis \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && chmod 777 /usr/local/etc/php

# Set working directory
WORKDIR /var/www/ms_auth

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www/ms_auth

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/ms_auth

# Change current user to www
USER www

# Composer install
RUN composer update --no-scripts
RUN composer dump-autoload

# Set /storage /public permission to public
RUN chmod -R 777 storage/ public/



# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

