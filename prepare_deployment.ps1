# Script PowerShell pour préparer le déploiement sur GitHub et Dokploy

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "   PREPARATION DEPLOIEMENT" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si Git est installé
try {
    $gitVersion = git --version 2>&1
    Write-Host "[OK] Git est installé" -ForegroundColor Green
    Write-Host "Version: $gitVersion" -ForegroundColor Gray
} catch {
    Write-Host "[ERREUR] Git n'est pas installé" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Configuration du repository GitHub:" -ForegroundColor Cyan
Write-Host "- Repository: https://github.com/adamdiaby05-prog/fintel-web.git" -ForegroundColor Gray
Write-Host "- Branch: main" -ForegroundColor Gray
Write-Host ""

$confirmation = Read-Host "Continuer avec la préparation? (O/N)"
if ($confirmation -ne "O" -and $confirmation -ne "o") {
    Write-Host "Opération annulée." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "[1/5] Vérification du dossier Git..." -ForegroundColor Cyan
if (Test-Path ".git") {
    Write-Host "[INFO] Repository Git existe déjà" -ForegroundColor Yellow
} else {
    Write-Host "[INFO] Initialisation du repository Git..." -ForegroundColor Yellow
    git init
}

Write-Host ""
Write-Host "[2/5] Vérification du README..." -ForegroundColor Cyan
if (Test-Path "README.md") {
    Write-Host "[OK] README.md existe" -ForegroundColor Green
} else {
    Write-Host "[INFO] Création du README.md..." -ForegroundColor Yellow
    "# fintel-web" | Out-File -FilePath README.md -Encoding utf8
}

Write-Host ""
Write-Host "[3/5] Ajout des fichiers au staging..." -ForegroundColor Cyan
git add .
Write-Host "[OK] Fichiers ajoutés" -ForegroundColor Green

Write-Host ""
Write-Host "[4/5] Vérification du remote..." -ForegroundColor Cyan
$remote = git remote get-url origin 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "[INFO] Remote existe: $remote" -ForegroundColor Yellow
    $updateRemote = Read-Host "Mettre à jour le remote? (O/N)"
    if ($updateRemote -eq "O" -or $updateRemote -eq "o") {
        git remote set-url origin https://github.com/adamdiaby05-prog/fintel-web.git
        Write-Host "[OK] Remote mis à jour" -ForegroundColor Green
    }
} else {
    Write-Host "[INFO] Ajout du remote..." -ForegroundColor Yellow
    git remote add origin https://github.com/adamdiaby05-prog/fintel-web.git
    Write-Host "[OK] Remote ajouté" -ForegroundColor Green
}

Write-Host ""
Write-Host "[5/5] Configuration de la branche..." -ForegroundColor Cyan
git branch -M main
Write-Host "[OK] Branche configurée sur 'main'" -ForegroundColor Green

Write-Host ""
Write-Host "=====================================" -ForegroundColor Green
Write-Host "   PREPARATION TERMINEE!" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Prochaines étapes:" -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Faire un commit:" -ForegroundColor White
Write-Host "   git commit -m 'first commit'" -ForegroundColor Gray
Write-Host ""
Write-Host "2. Pousser vers GitHub:" -ForegroundColor White
Write-Host "   git push -u origin main" -ForegroundColor Gray
Write-Host ""
Write-Host "3. Créer les tables dans PostgreSQL:" -ForegroundColor White
Write-Host "   psql -U postgres -d fintel -f database_setup_complete.sql" -ForegroundColor Gray
Write-Host ""
Write-Host "4. Configurer Dokploy avec:" -ForegroundColor White
Write-Host "   - Repository: https://github.com/adamdiaby05-prog/fintel-web.git" -ForegroundColor Gray
Write-Host "   - Branch: main" -ForegroundColor Gray
Write-Host ""

$commit = Read-Host "Faire le commit maintenant? (O/N)"
if ($commit -eq "O" -or $commit -eq "o") {
    $message = Read-Host "Message de commit (ou Enter pour 'first commit')"
    if ([string]::IsNullOrWhiteSpace($message)) {
        $message = "first commit"
    }
    git commit -m $message
    Write-Host "[OK] Commit créé" -ForegroundColor Green
    
    $push = Read-Host "Pousser vers GitHub maintenant? (O/N)"
    if ($push -eq "O" -or $push -eq "o") {
        git push -u origin main
        Write-Host "[OK] Code poussé vers GitHub!" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "Terminé!" -ForegroundColor Cyan

