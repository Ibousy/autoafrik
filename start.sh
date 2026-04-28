#!/bin/bash
set -e

echo "==> AutoAfrik — démarrage..."

echo "==> Création base de données..."
php -r "
\$host = getenv('DB_HOST') ?: '127.0.0.1';
\$port = getenv('DB_PORT') ?: 3306;
\$user = getenv('DB_USERNAME') ?: 'root';
\$pass = getenv('DB_PASSWORD') ?: '';
\$db   = getenv('DB_DATABASE') ?: 'autoafrik';
try {
    \$pdo = new PDO(\"mysql:host=\$host;port=\$port\", \$user, \$pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    \$pdo->exec(\"CREATE DATABASE IF NOT EXISTS \`\$db\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci\");
    echo \"=> Base \$db OK\n\";
} catch(Exception \$e) {
    echo 'DB create: ' . \$e->getMessage() . \"\n\";
}
"

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
