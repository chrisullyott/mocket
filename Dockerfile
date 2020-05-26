FROM php:7.4-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install Alpine packages
RUN apk update && \
    apk add nano openrc curl npm nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && \
    mkdir -p /root/.composer && \
    chmod -R ugo+rw /root/.composer

# Install NPM
RUN npm install
