#!/bin/bash
set -e

# Wait for database
while ! nc -z mysql 3306; do sleep 2; done

cp .env.example .env
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force || true
php artisan storage:link --force

exec "$@"