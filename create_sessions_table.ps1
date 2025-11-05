# Script PowerShell pour créer la table sessions dans PostgreSQL

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "   CRÉATION TABLE SESSIONS" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

Write-Host "[1/2] Création de la table sessions..." -ForegroundColor Cyan
try {
    $sqlFile = Join-Path $PSScriptRoot "database_create_sessions.sql"
    if (-not (Test-Path $sqlFile)) {
        Write-Host "[ERREUR] Fichier database_create_sessions.sql introuvable" -ForegroundColor Red
        exit 1
    }

    $result = Get-Content $sqlFile | psql -U postgres -d fintel 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "[OK] Table sessions créée avec succès" -ForegroundColor Green
    } else {
        # Vérifier si c'est juste un conflit d'insertion (table déjà créée)
        if ($result -match "already exists") {
            Write-Host "[INFO] La table sessions existe déjà" -ForegroundColor Yellow
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
Write-Host "=====================================" -ForegroundColor Green
Write-Host "   TERMINÉ!" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "La table sessions a été créée avec succès." -ForegroundColor Cyan
Write-Host "Vous pouvez maintenant démarrer le serveur Laravel:" -ForegroundColor Cyan
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""

