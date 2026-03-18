FROM php:8.3-fpm-alpine

# ---- Dépendances système ----
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    zip \
    unzip \
    git \
    oniguruma-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# ---- Extensions PHP ----
# tokenizer, ctype, fileinfo sont déjà bundlés dans php:8.3-fpm-alpine
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    bcmath \
    pcntl \
    opcache \
    && docker-php-ext-enable opcache

# ---- Composer ----
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---- Répertoire de travail ----
WORKDIR /var/www/html

# ---- Copie des fichiers ----
COPY . .

# ---- Dépendances PHP (production) ----
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ---- Permissions storage & cache ----
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ---- Config nginx ----
COPY docker/nginx.conf /etc/nginx/nginx.conf

# ---- Config supervisord ----
COPY docker/supervisord.conf /etc/supervisord.conf

# ---- Script de démarrage ----
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
