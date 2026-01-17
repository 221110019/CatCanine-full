#!/bin/bash
set -e

echo "=== Laravel Startup ==="

echo "Waiting for MySQL..."
MAX_RETRIES=30
RETRY_COUNT=0
while ! nc -z mysql 3306; do
    sleep 2
    RETRY_COUNT=$((RETRY_COUNT+1))
    if [ $RETRY_COUNT -ge $MAX_RETRIES ]; then
        echo "ERROR: MySQL not available after 60 seconds"
        exit 1
    fi
done
echo "MySQL is ready!"

if [ "$(id -u)" = "0" ]; then
    echo "Running as root: Setting up Laravel..."
    
    echo "Creating cache directories..."
    mkdir -p /var/www/html/bootstrap/cache
    mkdir -p /var/www/html/storage/framework/cache
    mkdir -p /var/www/html/storage/framework/sessions
    mkdir -p /var/www/html/storage/framework/views
    mkdir -p /var/www/html/storage/logs
    echo "Fixing permissions..."
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
    echo "Creating storage link..."
    php artisan storage:link --force || echo "Storage link already exists or failed"
    echo "Clearing old caches..."
    php artisan config:clear || true
    php artisan cache:clear || true
    php artisan view:clear || true
    php artisan route:clear || true
    echo "Caching configuration..."
    php artisan config:cache || echo "Config cache failed"
    php artisan route:cache || echo "Route cache failed" 
    php artisan view:cache || echo "View cache failed"
    echo "Switching to www-data user..."
    exec sudo -u www-data "$@"
else
    echo "Running as www-data..."
    exec "$@"