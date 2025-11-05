# Configuration de l'Interface Admin

## Étape 1: Créer la table Admin dans PostgreSQL

Exécutez le script SQL suivant dans votre base de données PostgreSQL:

**Option 1: Via psql**
```bash
psql -U postgres -d fintel -f database_create_admin.sql
```

**Option 2: Via pgAdmin**
- Ouvrez pgAdmin
- Connectez-vous à la base de données `fintel`
- Exécutez le contenu du fichier `database_create_admin.sql`

**Option 3: Via psql directement**
```bash
psql -U postgres -d fintel
```

Puis copiez-collez le contenu du fichier `database_create_admin.sql`

## Étape 2: Vérifier la création

Après avoir exécuté le script, vérifiez que la table existe:

```sql
SELECT * FROM admins;
```

Vous devriez voir un administrateur avec:
- **Email:** admin@fintel.com
- **Mot de passe:** admin123
- **Nom:** Admin Fintel

## Étape 3: Accéder à l'interface Admin

1. Démarrez le serveur Laravel:
   ```bash
   php artisan serve
   ```

2. Accédez à: **http://localhost:8000/admin/login**

3. Connectez-vous avec:
   - **Email:** admin@fintel.com
   - **Mot de passe:** admin123

## Fonctionnalités Admin

### Dashboard
- Vue d'ensemble des statistiques
- Nombre total d'utilisateurs
- Utilisateurs actifs et vérifiés
- Total des transactions
- Solde total des portefeuilles
- Utilisateurs récents
- Transactions récentes

### Gestion des Utilisateurs
- Liste complète des utilisateurs
- Informations détaillées par utilisateur
- Statut de vérification
- Statut actif/inactif

### Gestion des Transactions
- Liste complète des transactions
- Statistiques par statut (complété, en attente, échoué)
- Informations détaillées (montant, type, réseau)
- Filtres et pagination

## Sécurité

⚠️ **Important:** Changez le mot de passe par défaut après la première connexion!

Pour changer le mot de passe via SQL:
```sql
UPDATE admins 
SET password = '$2y$12$...' -- Nouveau hash généré avec Hash::make()
WHERE email = 'admin@fintel.com';
```

## Structure de la base de données

```sql
-- Table admins
CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
```

## URLs

- **Login Admin:** http://localhost:8000/admin/login
- **Dashboard Admin:** http://localhost:8000/admin/dashboard
- **Liste Utilisateurs:** http://localhost:8000/admin/users
- **Liste Transactions:** http://localhost:8000/admin/transactions

## Troubleshooting

### Impossible de se connecter
- Vérifiez que la table `admins` existe
- Vérifiez que l'administrateur par défaut a été créé
- Vérifiez les logs: `storage/logs/laravel.log`

### Erreur 500
- Nettoyez le cache: `php artisan cache:clear`
- Vérifiez les permissions sur `storage/` et `bootstrap/cache/`

### Erreur de hash de mot de passe
- Réexécutez `php artisan tinker --execute="echo Hash::make('votre_mot_de_passe');"`
- Copiez le nouveau hash dans la base de données

## Support

Pour toute question, consultez la documentation Laravel ou contactez l'équipe de développement.

