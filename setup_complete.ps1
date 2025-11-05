# Script PowerShell pour installer COMPLÈTEMENT Fintel Web
# Auteur: Fintel
# Date: 2025

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "   INSTALLATION COMPLÈTE FINTEL WEB" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si psql est installé
try {
    $psqlVersion = psql --version 2>&1
    Write-Host "[OK] PostgreSQL est installé" -ForegroundColor Green
    Write-Host "Version: $psqlVersion" -ForegroundColor Gray
} catch {
    Write-Host "[ERREUR] PostgreSQL n'est pas installé ou psql n'est pas dans le PATH" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Configuration de la base de données:" -ForegroundColor Cyan
Write-Host "- Host: 127.0.0.1" -ForegroundColor Gray
Write-Host "- Port: 5432" -ForegroundColor Gray
Write-Host "- Database: fintel" -ForegroundColor Gray
Write-Host "- Username: postgres" -ForegroundColor Gray
Write-Host ""

$confirmation = Read-Host "Continuer avec l'installation complète? (O/N)"
if ($confirmation -ne "O" -and $confirmation -ne "o") {
    Write-Host "Installation annulée." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "[1/4] Vérification de la connexion à PostgreSQL..." -ForegroundColor Cyan
try {
    $result = psql -U postgres -d fintel -c "SELECT version();" 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[OK] Connexion réussie à la base de données fintel" -ForegroundColor Green
    } else {
        Write-Host "[ERREUR] Impossible de se connecter à la base de données" -ForegroundColor Red
        Write-Host $result -ForegroundColor Red
        exit 1
    }
} catch {
    Write-Host "[ERREUR] Problème lors de la connexion" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "[2/4] Création de la table sessions..." -ForegroundColor Cyan
try {
    $sqlFile = Join-Path $PSScriptRoot "database_create_sessions.sql"
    if (Test-Path $sqlFile) {
        $result = Get-Content $sqlFile | psql -U postgres -d fintel 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "[OK] Table sessions créée avec succès" -ForegroundColor Green
        } elseif ($result -match "already exists") {
            Write-Host "[INFO] La table sessions existe déjà" -ForegroundColor Yellow
        }
    }
} catch {
    Write-Host "[INFO] Sessions ignoré, continuant..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "[3/4] Création de la table admins..." -ForegroundColor Cyan
try {
    $sqlFile = Join-Path $PSScriptRoot "database_create_admin.sql"
    if (Test-Path $sqlFile) {
        $result = Get-Content $sqlFile | psql -U postgres -d fintel 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "[OK] Table admins créée avec succès" -ForegroundColor Green
        } elseif ($result -match "already exists") {
            Write-Host "[INFO] La table admins existe déjà" -ForegroundColor Yellow
        }
    }
} catch {
    Write-Host "[INFO] Admins ignoré, continuant..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "[4/4] Vérification des tables créées..." -ForegroundColor Cyan
$tables = @("users", "admins", "transactions", "wallets", "sessions")
foreach ($table in $tables) {
    try {
        $result = psql -U postgres -d fintel -c "SELECT COUNT(*) FROM $table LIMIT 1;" 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "  [OK] Table $table existe" -ForegroundColor Green
        } else {
            Write-Host "  [MANQUANT] Table $table n'existe pas" -ForegroundColor Red
        }
    } catch {
        Write-Host "  [ERREUR] Impossible de vérifier $table" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "[VERIFICATION] Liste des administrateurs:" -ForegroundColor Cyan
try {
    $admins = psql -U postgres -d fintel -c "SELECT id, email, first_name, last_name FROM admins LIMIT 5;" 2>&1
    Write-Host $admins -ForegroundColor Gray
} catch {
    Write-Host "[INFO] Aucun admin trouvé ou table inexistante" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=====================================" -ForegroundColor Green
Write-Host "   INSTALLATION TERMINÉE!" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Accès à l'application:" -ForegroundColor Cyan
Write-Host "  Interface Utilisateur:" -ForegroundColor White
Write-Host "    http://localhost:8000" -ForegroundColor Gray
Write-Host "    http://localhost:8000/register (Inscription)" -ForegroundColor Gray
Write-Host "    http://localhost:8000/login (Connexion)" -ForegroundColor Gray
Write-Host ""
Write-Host "  Interface Admin:" -ForegroundColor White
Write-Host "    http://localhost:8000/admin/login" -ForegroundColor Gray
Write-Host "    Email: admin@fintel.com" -ForegroundColor Gray
Write-Host "    Mot de passe: admin123" -ForegroundColor Gray
Write-Host ""
Write-Host "IMPORTANT: Changez le mot de passe admin après la première connexion!" -ForegroundColor Yellow
Write-Host ""

$startServer = Read-Host "Démarrer le serveur Laravel maintenant? (O/N)"
if ($startServer -eq "O" -or $startServer -eq "o") {
    Write-Host ""
    Write-Host "Nettoyage du cache..." -ForegroundColor Cyan
    php artisan cache:clear 2>&1 | Out-Null
    php artisan config:clear 2>&1 | Out-Null
    
    Write-Host ""
    Write-Host "Démarrage du serveur Laravel..." -ForegroundColor Cyan
    Write-Host "Le serveur sera accessible sur http://localhost:8000" -ForegroundColor Green
    Write-Host "Appuyez sur Ctrl+C pour arrêter le serveur" -ForegroundColor Yellow
    Write-Host ""
    php artisan serve
}

Write-Host ""
Write-Host "Au revoir!" -ForegroundColor Cyan

