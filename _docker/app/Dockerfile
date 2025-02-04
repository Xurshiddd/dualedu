# _docker/app/Dockerfile
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip unzip \
    git \
    curl \
    gnupg && \
    docker-php-ext-install pdo_mysql bcmath gd zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Copy custom php.ini configuration
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install Composer globally
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www

# Copy in the application code
COPY . .

# Install PHP and Node.js dependencies
RUN composer install && npm install && npm run build
