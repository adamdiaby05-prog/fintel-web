# Fintel Web

Application web Laravel pour le système Fintel - Interface d'authentification et de gestion admin.

## 🚀 Déploiement sur Dokploy

### Prérequis

- PostgreSQL installé et configuré
- PHP 8.2+ 
- Composer
- Git

### Installation

1. **Cloner le repository**
```bash
git clone https://github.com/adamdiaby05-prog/fintel-web.git
cd fintel-web
```

2. **Installer les dépendances**
```bash
composer install --no-dev --optimize-autoloader
```

3. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données dans `.env`**
```env
DB_CONNECTION=pgsql
DB_HOST=your_host
DB_PORT=5432
DB_DATABASE=fintel
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

5. **Créer les tables manquantes**
```bash
psql -U postgres -d fintel -f database_setup_complete.sql
```

6. **Configurer les permissions**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

7. **Optimiser l'application**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📋 Structure de la Base de Données

### Tables existantes (déjà dans votre base)
- `users` - Utilisateurs de l'application
- `transactions` - Transactions financières
- `wallets` - Portefeuilles utilisateurs
- `otps` - Codes OTP

### Tables à créer (via `database_setup_complete.sql`)
- `admins` - Administrateurs
- `sessions` - Sessions Laravel
- `cache` - Cache Laravel
- `cache_locks` - Verrous de cache
- `jobs` - Jobs de queue
- `job_batches` - Batchs de jobs
- `failed_jobs` - Jobs échoués

## 🔐 Configuration Admin

### Créer un admin par défaut

Après avoir créé les tables, créez un admin:

```sql
-- Générer un hash de mot de passe (via php artisan tinker)
-- php artisan tinker --execute="echo Hash::make('votre_mot_de_passe');"

INSERT INTO admins (email, password, first_name, last_name, is_active)
VALUES (
    'admin@fintel.com',
    '$2y$12$...', -- Remplacez par le hash généré
    'Admin',
    'Fintel',
    TRUE
);
```

## 🌐 URLs

- **Interface Utilisateur:** `/register`, `/login`, `/dashboard`
- **Interface Admin:** `/admin/register`, `/admin/login`, `/admin/dashboard`

## 📚 Documentation

Consultez les fichiers de documentation:
- `SETUP_ADMIN.md` - Installation admin
- `QUICK_START.md` - Démarrage rapide
- `database_setup_complete.sql` - Script SQL complet

## 🛠️ Maintenance

### Commandes utiles
```bash
# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Optimiser
php artisan optimize

# Voir les logs
tail -f storage/logs/laravel.log
```

## 📝 Notes

- Les sessions sont stockées en base de données PostgreSQL
- L'authentification admin utilise un guard séparé
- Les mots de passe sont hashés avec Bcrypt

## 🔒 Sécurité

- Protection CSRF sur tous les formulaires
- Validation des données côté serveur
- Hashage Bcrypt des mots de passe
- Sessions sécurisées
- Middleware d'authentification

## 📄 Licence

Propriétaire - Fintel
