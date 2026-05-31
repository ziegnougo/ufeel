#!/bin/bash
set -e

cd /var/www/html

# Utiliser l'URL Render automatiquement si APP_URL n'est pas défini
if [ -z "$APP_URL" ] && [ -n "$RENDER_EXTERNAL_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

# Migrations base de données
php artisan migrate --force

# Démarrer Apache
exec apache2-foreground
