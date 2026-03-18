#!/bin/sh

echo "==> Génération du fichier .env..."
printenv | grep -E '^(APP_|DB_|SESSION_|CACHE_|QUEUE_|LOG_|MAIL_|BROADCAST_|FILESYSTEM_|REDIS_|BCRYPT_|VITE_)' > /var/www/html/.env

echo "==> Génération de la clé..."
php artisan key:generate --no-interaction --force || echo "WARN: key:generate échoué"

echo "==> Migrations..."
php artisan migrate --force --no-interaction || echo "WARN: migrate échoué"

echo "==> Cache Laravel..."
php artisan config:cache  || echo "WARN: config:cache échoué"
php artisan route:cache   || echo "WARN: route:cache échoué"
php artisan view:cache    || echo "WARN: view:cache échoué"

echo "==> Démarrage supervisord..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
