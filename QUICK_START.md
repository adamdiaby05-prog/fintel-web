# 🚀 Guide de Démarrage Rapide - Fintel Web

## ⚡ Démarrage Ultra-Rapide (3 minutes)

### Étape 1: Installer la table admin (1 min)
```powershell
cd fintel-web
.\install_admin.ps1
```

### Étape 2: Démarrer le serveur (1 min)
```bash
php artisan serve
```

### Étape 3: Accéder à l'application (1 min)
- **Interface Utilisateur:** http://localhost:8000
- **Interface Admin:** http://localhost:8000/admin/login

## 📍 Deux Interfaces

### 🌐 Interface Utilisateur
**URL:** http://localhost:8000

**Fonctionnalités:**
- Inscription avec numéro de téléphone
- Connexion avec téléphone + mot de passe
- Dashboard utilisateur

### 🛡️ Interface Admin
**URL:** http://localhost:8000/admin/login

**Identifiants:**
- Email: admin@fintel.com
- Mot de passe: admin123

**Fonctionnalités:**
- Dashboard avec statistiques
- Liste de tous les utilisateurs
- Liste de toutes les transactions
- Statistiques détaillées

## 🔐 Identifiants

### Admin (par défaut)
- **Email:** admin@fintel.com
- **Mot de passe:** admin123
- ⚠️ **Changez ce mot de passe après la première connexion!**

### Utilisateur (à créer)
1. Aller sur http://localhost:8000/register
2. S'inscrire avec un numéro de téléphone
3. Se connecter

## 🎯 Actions Rapides

### Créer un utilisateur de test
1. Aller sur http://localhost:8000/register
2. Remplir le formulaire
3. Se connecter

### Voir tous les utilisateurs (Admin)
1. Se connecter à http://localhost:8000/admin/login
2. Cliquer sur "Utilisateurs"

### Voir toutes les transactions (Admin)
1. Se connecter à http://localhost:8000/admin/login
2. Cliquer sur "Transactions"

## 🛠️ Commandes Essentielles

### Démarrer
```bash
php artisan serve
```

### Nettoyer le cache
```bash
php artisan cache:clear
```

### Voir les logs
```bash
Get-Content storage\logs\laravel.log -Tail 50
```

### Tester la base de données
```bash
php artisan tinker --execute="echo 'Connected!'"
```

## 📊 Statistiques Affichées (Admin)

- 📊 Total utilisateurs
- ✅ Utilisateurs actifs
- ✓ Utilisateurs vérifiés
- 💰 Total transactions
- 💳 Solde total portefeuilles
- 📋 10 derniers utilisateurs
- 💸 20 dernières transactions

## 🔗 Liens Rapides

| Description | URL |
|-------------|-----|
| Accueil utilisateur | http://localhost:8000 |
| Login utilisateur | http://localhost:8000/login |
| Register utilisateur | http://localhost:8000/register |
| Dashboard utilisateur | http://localhost:8000/dashboard |
| **Login admin** | **http://localhost:8000/admin/login** |
| **Dashboard admin** | **http://localhost:8000/admin/dashboard** |
| **Utilisateurs admin** | **http://localhost:8000/admin/users** |
| **Transactions admin** | **http://localhost:8000/admin/transactions** |

## ⚙️ Configuration

### Base de données (.env)
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fintel
DB_USERNAME=postgres
DB_PASSWORD=0000
```

### Tables utilisées
- `users` - Utilisateurs de l'application
- `admins` - Administrateurs
- `transactions` - Transactions financières
- `wallets` - Portefeuilles des utilisateurs

## 🐛 Problèmes Courants

### "Unable to connect to database"
- Vérifiez que PostgreSQL est démarré
- Vérifiez les identifiants dans `.env`

### "Table admins does not exist"
- Exécutez: `.\install_admin.ps1`
- Ou: `psql -U postgres -d fintel -f database_create_admin.sql`

### "Page 500"
- Nettoyez le cache: `php artisan cache:clear`
- Vérifiez les logs: `storage/logs/laravel.log`

### "Login failed"
- Vérifiez l'email et le mot de passe
- Vérifiez que l'utilisateur existe: `SELECT * FROM admins;`

## 📚 Documentation Complète

- **README.md** - Documentation générale
- **SETUP_ADMIN.md** - Installation détaillée admin
- **ADMIN_SETUP_COMPLETE.md** - Récapitulatif complet
- **database_create_admin.sql** - Script SQL commenté

## ✅ Checklist

- [ ] PostgreSQL installé et démarré
- [ ] Base de données `fintel` créée
- [ ] Tables `users`, `transactions`, `wallets` existent
- [ ] Script `install_admin.ps1` exécuté
- [ ] Table `admins` créée
- [ ] Serveur Laravel démarré
- [ ] Test de connexion admin réussi
- [ ] Changement du mot de passe admin

## 🎉 C'est Parti!

Votre application Fintel Web est maintenant prête!

**Prochaine étape:** Créez votre premier utilisateur et explorez l'interface admin.

---

**Besoin d'aide?** Consultez les fichiers de documentation dans `fintel-web/`

