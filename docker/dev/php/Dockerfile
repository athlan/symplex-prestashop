FROM php:7.3-cli

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql
