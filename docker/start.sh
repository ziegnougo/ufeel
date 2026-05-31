#!/bin/bash
set -e

cd /var/www/html

# APP_URL depuis Render si non défini
if [ -z "$APP_URL" ] && [ -n "$RENDER_EXTERNAL_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

# Scripts post-composer (skippés au build, exécutés ici avec .env disponible)
php artisan package:discover --ansi || true
php artisan filament:upgrade || true

# Lien storage
php artisan storage:link --force || true

# Migrations
php artisan migrate --force

# Démarrer Apache
exec apache2-foreground
