FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    bash \
    icu-dev \
    mysql-client \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install \
    intl \
    pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/symfony

# Install Symfony CLI
# The installer script creates the binary in /root/.symfony5/bin
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
