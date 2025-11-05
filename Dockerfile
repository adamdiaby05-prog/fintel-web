# Dockerfile pour Fintel Web - Laravel avec Nginx
FROM php:8.2-fpm

# Installer Nginx et les dépendances système
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application
COPY . /var/www/html

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copier la configuration Nginx
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Copier le script de démarrage
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Générer la clé d'application si elle n'existe pas (sera écrasée par .env si défini)
RUN php artisan key:generate --ansi || true

# Exposer le port 80 pour Nginx
EXPOSE 80

# Commande par défaut
CMD ["/start.sh"]
