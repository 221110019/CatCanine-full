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

# Create minimal cached config so Laravel boots
cat > bootstrap/cache/config.php << 'CONFIG'
<?php return [
  'app' => [
    'key' => getenv('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'name' => 'Laravel',
    'env' => 'production',
    'debug' => false,
  ],
];
CONFIG

php artisan storage:link --force || true

echo "Starting services..."
service php8.3-fpm start
service nginx start

tail -f /var/log/nginx/access.log
