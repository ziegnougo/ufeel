FROM php:8.4-apache

# Apache mod_rewrite
RUN a2enmod rewrite headers

# Dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip unzip git curl \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP (sans opcache — déjà compilé dans l'image de base)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_pgsql zip gd

# Activer opcache sans recompiler
RUN docker-php-ext-enable opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache : servir depuis /public
RUN sed -i \
    's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

RUN printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' >> /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY . .
RUN rm -f .env

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

RUN php artisan storage:link || true

COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
