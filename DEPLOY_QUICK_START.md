# ⚡ Déploiement Rapide - Dokploy

## 🚀 En 3 Étapes

### Étape 1: Préparer GitHub

```powershell
cd C:\Users\ROG\Documents\fintel\fintel-web
.\prepare_deployment.ps1
```

Ou manuellement:

```bash
git init
git add .
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/adamdiaby05-prog/fintel-web.git
git push -u origin main
```

### Étape 2: Créer les Tables Manquantes

Sur votre serveur PostgreSQL (Dokploy):

```bash
psql -U postgres -d fintel -f database_setup_complete.sql
```

Ou via psql:

```sql
\i database_setup_complete.sql
```

### Étape 3: Configurer Dokploy

1. **Créer une application Laravel**
2. **Repository:** `https://github.com/adamdiaby05-prog/fintel-web.git`
3. **Branch:** `main`
4. **Variables d'environnement:** Voir ci-dessous

## 📋 Variables d'Environnement (.env)

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
SESSION_ENCRYPT=false

CACHE_STORE=database
QUEUE_CONNECTION=database
```

## 🔧 Commandes Dokploy

### Build Command
```bash
composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### Start Command
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 📊 Tables à Créer

Le script `database_setup_complete.sql` crée:
- ✅ admins
- ✅ sessions
- ✅ cache
- ✅ cache_locks
- ✅ jobs
- ✅ job_batches
- ✅ failed_jobs

## ✅ Checklist

- [ ] Code poussé sur GitHub
- [ ] Tables créées dans PostgreSQL
- [ ] Application créée dans Dokploy
- [ ] Variables d'environnement configurées
- [ ] Application déployée
- [ ] Tests de connexion

---

**Bon déploiement! 🚀**

