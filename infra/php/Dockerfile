FROM php:8.3-fpm

COPY ./infra/php/php.ini /usr/local/etc/php/php.ini

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    ca-certificates \
    net-tools \
    libgmp-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    make \
    python3 \
    build-essential \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install gmp \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql

# Install Node.js LTS + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g concurrently


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verify
RUN node -v && npm -v && npx -v

# Copy app code to /var/www/html
COPY ./php /var/www/html

WORKDIR /var/www/html

# Expose ports
EXPOSE 9000 5173

# Install npm dependencies
RUN npm install

# Install PHP dependencies
RUN composer install

CMD ["composer", "run", "dev"]