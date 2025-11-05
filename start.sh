#!/bin/bash

# Créer .env si manquant
if [ ! -f .env ]; then
	if [ -f .env.example ]; then
		cp .env.example .env
	else
		printf "APP_NAME=Fintel\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=false\nAPP_URL=http://localhost\nDB_CONNECTION=pgsql\nDB_HOST=localhost\nDB_PORT=5432\nDB_DATABASE=postgres\nDB_USERNAME=postgres\nDB_PASSWORD=postgres\nSESSION_DRIVER=database\n" > .env
	fi
fi

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
