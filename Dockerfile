FROM ubuntu:24.04
# FROM ubuntu:24.04-slim

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y \
    php8.3 \
    php8.3-cli \
    php8.3-mysql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-curl \
    php8.3-gd \
    php8.3-intl \
    composer \
    nodejs \
    npm \
    netcat-openbsd \
    && apt-get clean

COPY . .

RUN composer install --optimize-autoloader
RUN npm install && npm run build

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]