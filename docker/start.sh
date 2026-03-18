#!/bin/sh
set -e

echo "==> Génération de la clé si absente..."
php artisan key:generate --no-interaction --force

echo "==> Migrations..."
php artisan migrate --force --no-interaction

echo "==> Mise en cache config/routes/vues..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Démarrage nginx + php-fpm..."
exec supervisord -c /etc/supervisord.conf
