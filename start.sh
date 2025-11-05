#!/bin/bash

# Générer la clé d'application si elle n'existe pas
php artisan key:generate --force 2>/dev/null || true

# Mettre en cache la configuration Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer Nginx en arrière-plan
service nginx start

# Démarrer PHP-FPM en avant-plan
php-fpm
