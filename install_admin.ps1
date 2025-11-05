# Script PowerShell pour installer la table admin dans PostgreSQL
# Auteur: Fintel
# Date: 2025

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "   INSTALLATION ADMIN FINTEL" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si psql est installé
try {
    $psqlVersion = psql --version 2>&1
    Write-Host "[OK] PostgreSQL est installé" -ForegroundColor Green
    Write-Host "Version: $psqlVersion" -ForegroundColor Gray
} catch {
    Write-Host "[ERREUR] PostgreSQL n'est pas installé ou psql n'est pas dans le PATH" -ForegroundColor Red
    Write-Host "Installez PostgreSQL et assurez-vous que psql est dans votre PATH" -ForegroundColor Yellow
    exit 1
}

Write-Host ""
Write-Host "Configuration de la base de données:" -ForegroundColor Cyan
Write-Host "- Host: 127.0.0.1" -ForegroundColor Gray
Write-Host "- Port: 5432" -ForegroundColor Gray
Write-Host "- Database: fintel" -ForegroundColor Gray
Write-Host "- Username: postgres" -ForegroundColor Gray
Write-Host ""

$confirmation = Read-Host "Continuer? (O/N)"
if ($confirmation -ne "O" -and $confirmation -ne "o") {
    Write-Host "Installation annulée." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "[1/2] Vérification de la connexion à PostgreSQL..." -ForegroundColor Cyan
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
Write-Host "[1/3] Création de la table sessions..." -ForegroundColor Cyan
try {
    $sqlFile = Join-Path $PSScriptRoot "database_create_sessions.sql"
    if (Test-Path $sqlFile) {
        $result = Get-Content $sqlFile | psql -U postgres -d fintel 2>&1
        if ($LASTEXITCODE -eq 0) {
            Write-Host "[OK] Table sessions créée avec succès" -ForegroundColor Green
        } elseif ($result -match "already exists") {
            Write-Host "[INFO] La table sessions existe déjà" -ForegroundColor Yellow
        } else {
            Write-Host "[INFO] Problème avec sessions, continuant..." -ForegroundColor Yellow
        }
    } else {
        Write-Host "[INFO] Fichier sessions introuvable, ignoré" -ForegroundColor Yellow
    }
} catch {
    Write-Host "[INFO] Problème sessions, continuant..." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "[2/3] Création de la table admins..." -ForegroundColor Cyan
try {
    $sqlFile = Join-Path $PSScriptRoot "database_create_admin.sql"
    if (-not (Test-Path $sqlFile)) {
        Write-Host "[ERREUR] Fichier database_create_admin.sql introuvable" -ForegroundColor Red
        exit 1
    }

    $result = Get-Content $sqlFile | psql -U postgres -d fintel 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[OK] Table admins créée avec succès" -ForegroundColor Green
    } else {
        # Vérifier si c'est juste un conflit d'insertion (table déjà créée)
        if ($result -match "duplicate key value" -or $result -match "already exists") {
            Write-Host "[INFO] La table existe déjà, vérification..." -ForegroundColor Yellow
        } else {
            Write-Host "[ERREUR] Problème lors de la création de la table" -ForegroundColor Red
            Write-Host $result -ForegroundColor Red
            exit 1
        }
    }
} catch {
    Write-Host "[ERREUR] Problème lors de l'exécution du script SQL" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "[3/3] Vérification des tables..." -ForegroundColor Cyan

Write-Host ""
Write-Host "[VERIFICATION] Liste des administrateurs:" -ForegroundColor Cyan
try {
    $admins = psql -U postgres -d fintel -c "SELECT id, email, first_name, last_name, is_active FROM admins;" 2>&1
    Write-Host $admins -ForegroundColor Gray
} catch {
    Write-Host "[ERREUR] Impossible de lire la table admins" -ForegroundColor Red
}

Write-Host ""
Write-Host "=====================================" -ForegroundColor Green
Write-Host "   INSTALLATION TERMINÉE!" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Vous pouvez maintenant vous connecter à:" -ForegroundColor Cyan
Write-Host "  URL: http://localhost:8000/admin/login" -ForegroundColor White
Write-Host "  Email: admin@fintel.com" -ForegroundColor White
Write-Host "  Mot de passe: admin123" -ForegroundColor White
Write-Host ""
Write-Host "IMPORTANT: Changez le mot de passe par défaut après la première connexion!" -ForegroundColor Yellow
Write-Host ""

$startServer = Read-Host "Démarrer le serveur Laravel maintenant? (O/N)"
if ($startServer -eq "O" -or $startServer -eq "o") {
    Write-Host ""
    Write-Host "Démarrage du serveur Laravel..." -ForegroundColor Cyan
    Write-Host "Appuyez sur Ctrl+C pour arrêter le serveur" -ForegroundColor Yellow
    Write-Host ""
    php artisan serve
}

Write-Host ""
Write-Host "Au revoir!" -ForegroundColor Cyan

