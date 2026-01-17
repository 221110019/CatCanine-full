#!/bin/bash
set -e

echo "=== Starting Laravel ==="

echo "Waiting for MySQL..."
until nc -z mysql 3306; do
  sleep 2
done
echo "MySQL is ready"

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

cd /var/www/html

# Clear old caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches properly
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage link exists
php artisan storage:link --force || true

echo "Starting services..."
# Run in foreground
php-fpm8.3 -F &
nginx -g "daemon off;"
