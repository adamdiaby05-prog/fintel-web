# 🚀 Guide de Déploiement sur Dokploy

## 📋 Étapes de Déploiement

### 1. Préparer le Repository GitHub

```bash
cd C:\Users\ROG\Documents\fintel\fintel-web

# Initialiser Git (si pas déjà fait)
git init

# Créer le README
echo "# fintel-web" >> README.md

# Ajouter tous les fichiers
git add .

# Premier commit
git commit -m "first commit"

# Renommer la branche
git branch -M main

# Ajouter le remote
git remote add origin https://github.com/adamdiaby05-prog/fintel-web.git

# Pousser vers GitHub
git push -u origin main
```

### 2. Créer les Tables Manquantes dans PostgreSQL

Connectez-vous à votre base PostgreSQL sur Dokploy:

```bash
psql -U postgres -d fintel
```

Ou via l'interface Dokploy.

Puis exécutez le script SQL:

```sql
-- Copier le contenu de database_setup_complete.sql
\i database_setup_complete.sql
```

Ou directement:

```bash
psql -U postgres -d fintel -f database_setup_complete.sql
```

### 3. Configurer Dokploy

#### Configuration de l'Application

1. **Créer une nouvelle application** dans Dokploy
2. **Type:** Laravel
3. **Repository:** `https://github.com/adamdiaby05-prog/fintel-web.git`
4. **Branch:** `main`

#### Variables d'Environnement

Dans Dokploy, ajoutez ces variables dans `.env`:

```env
APP_NAME=Fintel
APP_ENV=production
APP_KEY=base64:... # Générer avec: php artisan key:generate
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=pgsql
DB_HOST=postgres_host
DB_PORT=5432
DB_DATABASE=fintel
DB_USERNAME=postgres
DB_PASSWORD=your_password

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database
```

#### Script de Build

```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Script de Déploiement

```bash
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Créer un Admin par Défaut

Après le déploiement, connectez-vous à la base et créez un admin:

```sql
-- Générer un hash via: php artisan tinker --execute="echo Hash::make('admin123');"
INSERT INTO admins (email, password, first_name, last_name, is_active)
VALUES (
    'admin@fintel.com',
    '$2y$12$...', -- Remplacez par le hash généré
    'Admin',
    'Fintel',
    TRUE
);
```

### 5. Vérifier les Tables

```sql
\dt
```

Vous devriez voir:
- admins
- cache
- cache_locks
- failed_jobs
- job_batches
- jobs
- otps
- sessions
- transactions
- users
- wallets

## 🔧 Configuration Dokploy Recommandée

### PHP Version
- **Version:** 8.2 ou supérieure

### Build Command
```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Start Command
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Health Check
```bash
curl -f http://localhost:8000 || exit 1
```

## 📊 Base de Données

### Tables Nécessaires

| Table | Statut | Description |
|-------|--------|-------------|
| users | ✅ Existe | Utilisateurs |
| transactions | ✅ Existe | Transactions |
| wallets | ✅ Existe | Portefeuilles |
| otps | ✅ Existe | Codes OTP |
| admins | ⚠️ À créer | Administrateurs |
| sessions | ⚠️ À créer | Sessions Laravel |
| cache | ⚠️ À créer | Cache Laravel |
| jobs | ⚠️ À créer | Jobs queue |

### Script SQL

Le fichier `database_setup_complete.sql` contient toutes les tables manquantes.

## 🚨 Checklist de Déploiement

- [ ] Repository GitHub créé et poussé
- [ ] Application créée dans Dokploy
- [ ] Variables d'environnement configurées
- [ ] Script SQL exécuté (tables créées)
- [ ] Admin par défaut créé
- [ ] Application déployée
- [ ] Tests de connexion réussis
- [ ] Logs vérifiés

## 🐛 Dépannage

### Erreur: Table manquante
```bash
# Exécuter le script SQL
psql -U postgres -d fintel -f database_setup_complete.sql
```

### Erreur: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```

### Erreur: APP_KEY manquant
```bash
php artisan key:generate
```

### Voir les logs
```bash
tail -f storage/logs/laravel.log
```

## 📚 Ressources

- **Script SQL:** `database_setup_complete.sql`
- **README:** `README.md`
- **Documentation:** Voir les autres fichiers .md

---

**Bon déploiement! 🚀**

