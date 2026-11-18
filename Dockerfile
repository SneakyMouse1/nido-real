FROM php:8.4-fpm

# System dependencies cached for a long time
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev libicu-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    libpq-dev rsync \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions layer
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip intl

# Node.js separate layer
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# First composer.json - to avoid reinstalling packages when code changes
COPY composer.json composer.lock ./
RUN composer install --no-interaction --optimize-autoloader --no-scripts --no-dev

# Then package.json
COPY package.json package-lock.json ./
RUN npm ci

# Now all code
COPY . .

ARG VITE_MAPBOX_TOKEN
ENV VITE_MAPBOX_TOKEN=$VITE_MAPBOX_TOKEN

RUN npm run build \
    && composer dump-autoload --optimize \
    && chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
