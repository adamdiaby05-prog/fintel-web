#!/bin/bash

# Mettre en cache la configuration Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer Nginx en arrière-plan
service nginx start

# Démarrer PHP-FPM en avant-plan
php-fpm
