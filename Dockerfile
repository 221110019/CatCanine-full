# ---------- Frontend build ----------
FROM node:20-bullseye AS frontend
WORKDIR /app

RUN npm config set registry https://registry.npmjs.org/ \
    && npm config set fetch-retries 5 \
    && npm config set fetch-retry-mintimeout 2000 \
    && npm config set fetch-retry-maxtimeout 120000

COPY package.json package-lock.json ./
RUN npm install --no-audit --no-fund --legacy-peer-deps

COPY . .
RUN npx vite build




# ---------- PHP dependencies ----------
FROM php:8.3-cli AS vendor
WORKDIR /app

RUN apt-get update && apt-get install -y unzip git curl ca-certificates \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress
RUN composer dump-autoload
RUN php artisan config:clear




# ---------- Runtime ----------
FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-zip php8.3-bcmath php8.3-curl php8.3-gd php8.3-intl \
    nginx netcat-openbsd sudo curl \
    && apt-get clean

COPY . .
COPY --from=frontend /app/public/build ./public/build
COPY --from=vendor /app/vendor ./vendor

COPY docker/nginx.conf /etc/nginx/sites-enabled/default
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN mkdir -p storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

ENTRYPOINT ["/entrypoint.sh"]
