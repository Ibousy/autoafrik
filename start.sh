#!/bin/bash
set -e

echo "==> AutoAfrik — démarrage..."

# Clear & cache config/routes/views
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear

echo "==> Migrations..."
php artisan migrate --force

echo "==> Demo data..."
php artisan autoafrik:ensure-demo

echo "==> Super admin..."
php artisan autoafrik:ensure-super-admin

echo "==> Storage link..."
php artisan storage:link || true

echo "==> Démarrage du serveur sur port ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
