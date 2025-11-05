#!/bin/bash

# Créer .env si manquant
if [ ! -f .env ]; then
	if [ -f .env.example ]; then
		cp .env.example .env
	else
		# Créer un .env minimal avec les variables d'environnement du conteneur si disponibles
		cat > .env <<EOF
APP_NAME=\${APP_NAME:-Fintel}
APP_ENV=\${APP_ENV:-production}
APP_KEY=
APP_DEBUG=\${APP_DEBUG:-false}
APP_URL=\${APP_URL:-http://localhost}

LOG_CHANNEL=\${LOG_CHANNEL:-stack}
LOG_LEVEL=\${LOG_LEVEL:-error}

DB_CONNECTION=\${DB_CONNECTION:-pgsql}
DB_HOST=\${DB_HOST:-localhost}
DB_PORT=\${DB_PORT:-5432}
DB_DATABASE=\${DB_DATABASE:-postgres}
DB_USERNAME=\${DB_USERNAME:-postgres}
DB_PASSWORD=\${DB_PASSWORD:-postgres}

BROADCAST_DRIVER=\${BROADCAST_DRIVER:-log}
CACHE_DRIVER=\${CACHE_DRIVER:-file}
FILESYSTEM_DISK=\${FILESYSTEM_DISK:-local}
QUEUE_CONNECTION=\${QUEUE_CONNECTION:-sync}
SESSION_DRIVER=\${SESSION_DRIVER:-database}
SESSION_LIFETIME=\${SESSION_LIFETIME:-120}
EOF
	fi
fi

# Remplacer les variables d'environnement dans .env si elles existent
if [ -n "$APP_NAME" ]; then
	sed -i "s/^APP_NAME=.*/APP_NAME=$APP_NAME/" .env
fi
if [ -n "$APP_ENV" ]; then
	sed -i "s/^APP_ENV=.*/APP_ENV=$APP_ENV/" .env
fi
if [ -n "$APP_KEY" ]; then
	sed -i "s/^APP_KEY=.*/APP_KEY=$APP_KEY/" .env
fi
if [ -n "$APP_DEBUG" ]; then
	sed -i "s/^APP_DEBUG=.*/APP_DEBUG=$APP_DEBUG/" .env
fi
if [ -n "$APP_URL" ]; then
	sed -i "s|^APP_URL=.*|APP_URL=$APP_URL|" .env
fi
if [ -n "$DB_HOST" ]; then
	sed -i "s/^DB_HOST=.*/DB_HOST=$DB_HOST/" .env
fi
if [ -n "$DB_PORT" ]; then
	sed -i "s/^DB_PORT=.*/DB_PORT=$DB_PORT/" .env
fi
if [ -n "$DB_DATABASE" ]; then
	sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
fi
if [ -n "$DB_USERNAME" ]; then
	sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
fi
if [ -n "$DB_PASSWORD" ]; then
	sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env
fi
if [ -n "$SESSION_DRIVER" ]; then
	sed -i "s/^SESSION_DRIVER=.*/SESSION_DRIVER=$SESSION_DRIVER/" .env
fi

# Vérifier si APP_KEY est vide ou absente et la générer
if ! grep -q "^APP_KEY=base64:" .env && ! grep -q "^APP_KEY=.*[A-Za-z0-9]" .env; then
	echo "Génération de APP_KEY..."
	php artisan key:generate --force
fi

# Mettre en cache la configuration Laravel
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Démarrer Nginx en arrière-plan
service nginx start

# Démarrer PHP-FPM en avant-plan
exec php-fpm
