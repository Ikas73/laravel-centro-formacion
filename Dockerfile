# Cambia la versión de PHP a 8.3
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Instalar dependencias PHP y Node.js/npm
# (Mismas dependencias que antes)
RUN apk update && apk add --no-cache \
    libpq-dev \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    autoconf \
    g++ \
    make \
    # Instalar extensiones PHP
    && docker-php-ext-install pdo pdo_pgsql \
    # Instalar extensión Redis para PHP
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Limpiar caché de apk
    && rm -rf /var/cache/apk/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código (manejado por volumen en desarrollo)
# COPY ./src /var/www/html

# Exponer puerto para FPM
EXPOSE 9000

# Comando por defecto (opcional si está en docker-compose.yml)
# CMD ["php-fpm"]