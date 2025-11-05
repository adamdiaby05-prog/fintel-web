# Checklist de Déploiement Dokploy - Fintel Web

## ✅ Préparation (Terminé)
- [x] Configuration Docker complète (Dockerfile, Nginx, script de démarrage)
- [x] Code poussé sur GitHub: `adamdiaby05-prog/fintel-web`
- [x] Guide de déploiement créé: `DOKPLOY_DEPLOY.md`

## 📋 Étapes de Déploiement

### 1. Configuration de la Base de Données dans Dokploy
- [ ] Connectez-vous à votre base de données PostgreSQL (`fintel-db-nez1ib`)
- [ ] Exécutez le script SQL `database_setup_complete.sql` pour créer:
  - Table `sessions`
  - Table `admins` avec admin par défaut

**Informations de connexion:**
- Host: `fintel-db-nez1ib`
- Port: `5432`
- User: `postgres`
- Password: `fymj9vjgg1hcgzsc`
- Database: `postgres`

### 2. Configuration de l'Application Web dans Dokploy

#### Paramètres Git
- [ ] Provider: GitHub
- [ ] Repository: `adamdiaby05-prog/fintel-web`
- [ ] Branch: `main`
- [ ] Build Path: `/`

#### Paramètres Docker
- [ ] Build Type: `Dockerfile`
- [ ] Docker File: `Dockerfile`
- [ ] Docker Context Path: `.`
- [ ] Docker Build Stage: (laisser vide)

#### Variables d'Environnement (Section "Environment")
Ajoutez ces variables dans Dokploy:

```env
APP_NAME=Fintel
APP_ENV=production
APP_KEY=(générer avec: php artisan key:generate)
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=pgsql
DB_HOST=fintel-db-nez1ib
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=fymj9vjgg1hcgzsc

SESSION_DRIVER=database
SESSION_LIFETIME=120

LOG_CHANNEL=stack
LOG_LEVEL=error
```

**Important:** 
- Remplacez `APP_KEY` par une clé générée (ou laissez-la vide pour la génération automatique)
- Remplacez `APP_URL` par votre domaine réel

### 3. Déploiement
- [ ] Cliquez sur "Deploy" dans Dokploy
- [ ] Surveillez les logs du build
- [ ] Vérifiez qu'il n'y a pas d'erreurs

### 4. Vérification Post-Déploiement
- [ ] Application accessible via votre domaine
- [ ] Test connexion admin: `/admin/login`
  - Email: `admin@fintel.com`
  - Password: `admin123`
- [ ] Test inscription utilisateur: `/register`
- [ ] Test connexion utilisateur: `/login`

### 5. Exécution des Migrations (si nécessaire)
Si des migrations sont nécessaires après le déploiement:
- [ ] Connectez-vous au terminal du conteneur via Dokploy
- [ ] Exécutez: `php artisan migrate --force`

## 🔍 Troubleshooting

### Erreur de connexion à la base de données
- Vérifiez que `DB_HOST=fintel-db-nez1ib` (pas `localhost`)
- Vérifiez que toutes les variables d'environnement sont correctement définies

### Erreur 500
- Vérifiez les logs dans Dokploy
- Vérifiez que `APP_KEY` est défini
- Vérifiez les permissions sur `storage/` et `bootstrap/cache/`

### Erreur de session
- Vérifiez que `SESSION_DRIVER=database` est défini
- Vérifiez que la table `sessions` existe dans la base de données

## 📝 Notes
- Le host de la base de données utilise le nom interne du service Dokploy: `fintel-db-nez1ib`
- N'oubliez pas d'exécuter `database_setup_complete.sql` avant le premier déploiement
- Les logs sont disponibles dans la section "Logs" de Dokploy


