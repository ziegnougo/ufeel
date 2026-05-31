#!/bin/bash

cd /var/www/html

# APP_URL depuis Render si non défini
if [ -z "$APP_URL" ] && [ -n "$RENDER_EXTERNAL_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

echo ">>> DB_CONNECTION=$DB_CONNECTION"
echo ">>> DB_HOST=$DB_HOST"
echo ">>> DB_PORT=$DB_PORT"
echo ">>> DB_DATABASE=$DB_DATABASE"
echo ">>> DB_USERNAME=$DB_USERNAME"

php artisan package:discover --ansi || true
php artisan filament:upgrade || true
php artisan storage:link --force || true

echo ">>> Lancement des migrations..."
php artisan migrate --force
STATUS=$?

if [ $STATUS -ne 0 ]; then
    echo ">>> ERREUR migration (code $STATUS) — vérifier les variables DB_*"
    exit 1
fi

echo ">>> Démarrage Apache..."
exec apache2-foreground
