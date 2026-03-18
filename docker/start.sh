#!/bin/sh
set -e

echo "==> Génération du fichier .env depuis les variables d'environnement..."

# Écrire toutes les variables d'environnement du container dans .env
# printenv génère KEY=VALUE sur chaque ligne
printenv | grep -E '^(APP_|DB_|SESSION_|CACHE_|QUEUE_|LOG_|MAIL_|BROADCAST_|FILESYSTEM_|REDIS_|BCRYPT_|VITE_)' > /var/www/html/.env

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
