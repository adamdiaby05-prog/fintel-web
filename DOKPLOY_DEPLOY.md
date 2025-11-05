# Guide de Déploiement Dokploy - Fintel Web

## Configuration de la Base de Données

### Informations de Connexion (Dokploy)
- **Internal Host**: `fintel-db-nez1ib`
- **Port**: `5432`
- **User**: `postgres`
- **Password**: `fymj9vjgg1hcgzsc`
- **Database Name**: `postgres`
- **Internal Connection URL**: `postgresql://postgres:fymj9vjgg1hcgzsc@fintel-db-nez1ib:5432/postgres`

## Configuration de l'Application Web dans Dokploy

### Paramètres de Déploiement

1. **Provider**: GitHub
   - Repository: `adamdiaby05-prog/fintel-web`
   - Branch: `main`
   - Build Path: `/`

2. **Build Type**: Dockerfile
   - Docker File: `Dockerfile`
   - Docker Context Path: `.`
   - Docker Build Stage: (laisser vide)

3. **Variables d'Environnement** (à configurer dans Dokploy)

Dans la section "Environment" de votre application Dokploy, ajoutez les variables suivantes:

```env
APP_NAME=Fintel
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://votre-domaine.com

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=fintel-db-nez1ib
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=fymj9vjgg1hcgzsc

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Étapes de Déploiement

### 1. Préparation de la Base de Données

Connectez-vous à votre base de données PostgreSQL sur Dokploy et exécutez le script `database_setup_complete.sql` pour créer les tables nécessaires:

```sql
-- Exécuter database_setup_complete.sql dans la base de données postgres
```

Ou utilisez l'interface Dokploy pour exécuter les scripts SQL nécessaires.

### 2. Configuration de l'Application

1. Dans Dokploy, allez dans votre application `fintel-web-yxyztc`
2. Allez dans l'onglet "Environment"
3. Ajoutez toutes les variables d'environnement listées ci-dessus
4. **Important**: Remplacez `YOUR_APP_KEY_HERE` par votre clé d'application Laravel

Pour générer une clé d'application, vous pouvez:
- Utiliser `php artisan key:generate` en local et copier la clé
- Ou laisser Dokploy générer la clé automatiquement si votre Dockerfile le permet

### 3. Configuration du Build

1. Vérifiez que le Build Type est défini sur "Dockerfile"
2. Vérifiez que "Docker File" est défini sur `Dockerfile`
3. Vérifiez que "Docker Context Path" est défini sur `.`

### 4. Déploiement

1. Cliquez sur "Deploy" dans Dokploy
2. Attendez que le build se termine
3. Vérifiez les logs pour s'assurer qu'il n'y a pas d'erreurs

### 5. Exécution des Migrations

Après le déploiement, vous devrez peut-être exécuter les migrations de la base de données. Vous pouvez le faire via:
- L'interface Dokploy (terminal/shell)
- Ou en ajoutant les commandes dans le Dockerfile

### 6. Création des Tables de Base de Données

Exécutez le script SQL `database_setup_complete.sql` dans votre base de données PostgreSQL pour créer:
- La table `sessions`
- La table `admins` avec un admin par défaut

## Vérification Post-Déploiement

1. Vérifiez que l'application est accessible via votre domaine
2. Testez la connexion admin: `https://votre-domaine.com/admin/login`
   - Email: `admin@fintel.com`
   - Password: `admin123`
3. Testez l'inscription d'un utilisateur: `https://votre-domaine.com/register`
4. Vérifiez les logs dans Dokploy pour détecter d'éventuelles erreurs

## Notes Importantes

- Assurez-vous que la base de données est accessible depuis le conteneur de l'application
- Le host de la base de données doit être `fintel-db-nez1ib` (nom interne du service)
- Les variables d'environnement sensibles (comme les mots de passe) doivent être configurées dans Dokploy, pas dans le code
- Assurez-vous que les permissions de stockage sont correctement configurées pour Laravel

## Troubleshooting

### Erreur de connexion à la base de données
- Vérifiez que le host est `fintel-db-nez1ib` et non `localhost`
- Vérifiez que les variables d'environnement sont correctement définies
- Vérifiez que la base de données est en cours d'exécution

### Erreur de permissions de stockage
- Assurez-vous que le dossier `storage` et `bootstrap/cache` ont les bonnes permissions (775)

### Erreur de session
- Assurez-vous que `SESSION_DRIVER=database` est défini
- Assurez-vous que la table `sessions` existe dans la base de données
