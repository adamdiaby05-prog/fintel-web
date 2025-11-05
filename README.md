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

#### Inscription
- URL: http://localhost:8000/register
- Champs requis:
  - Numéro de téléphone (unique)
  - Mot de passe (minimum 6 caractères)
  - Confirmation du mot de passe
  - Acceptation des conditions d'utilisation
- Champs optionnels:
  - Email
  - Prénom
  - Nom

#### Connexion
- URL: http://localhost:8000/login
- Authentification par numéro de téléphone et mot de passe

#### Tableau de bord
- URL: http://localhost:8000/dashboard
- Affichage des informations utilisateur
- Bouton de déconnexion

### Modèle User

Le modèle User a été adapté pour correspondre au schéma PostgreSQL existant:

**Champs principaux:**
- `phone_number` - Numéro de téléphone (unique, requis)
- `hashed_password` - Mot de passe hashé
- `email` - Email (unique, optionnel)
- `first_name` - Prénom
- `last_name` - Nom
- `is_active` - Statut actif
- `is_verified` - Statut vérifié
- `terms_accepted` - Acceptation des conditions

## Structure

```
fintel-web/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── AuthController.php    # Contrôleur d'authentification
│   └── Models/
│       └── User.php                   # Modèle User adapté
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php        # Page de connexion
│       │   └── register.blade.php     # Page d'inscription
│       ├── layouts/
│       │   └── app.blade.php          # Layout principal
│       └── dashboard.blade.php        # Tableau de bord
├── routes/
│   └── web.php                        # Routes de l'application
└── .env                               # Configuration environnement
```

## Dépendances

- PHP 8.2+
- Composer
- PostgreSQL avec extension pdo_pgsql
- Laravel 12

## Notes importantes

1. **Mot de passe:** Le champ utilisé dans la base est `hashed_password`, pas `password`
2. **Authentification:** L'authentification se fait par `phone_number`, pas par email
3. **Base de données:** La base PostgreSQL doit être accessible avec les identifiants configurés
4. **Sessions:** Les sessions utilisent la base de données PostgreSQL

## Développement

Pour tester l'application:

1. Démarrer le serveur: `php artisan serve`
2. Accéder à http://localhost:8000
3. S'inscrire avec un nouveau numéro de téléphone
4. Se connecter avec les identifiants créés
5. Accéder au tableau de bord

## Support

Pour toute question ou problème, consultez la documentation Laravel ou contactez l'équipe de développement.
