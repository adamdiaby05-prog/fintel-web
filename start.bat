@echo off
echo ====================================
echo    DEMARRAGE DE FINTEL WEB
echo ====================================
echo.

REM Vérifier si nous sommes dans le bon dossier
if not exist "artisan" (
    echo Erreur: Vous devez etre dans le dossier fintel-web
    pause
    exit /b 1
)

echo [1/3] Verification de la base de donnees PostgreSQL...
php artisan tinker --execute="DB::connection()->getPdo(); echo 'OK';" >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Impossible de se connecter a PostgreSQL
    echo Veuillez verifier:
    echo   - PostgreSQL est demarre
    echo   - Les identifiants dans .env sont corrects
    pause
    exit /b 1
)
echo Base de donnees: OK
echo.

echo [2/3] Nettoyage du cache...
php artisan cache:clear >nul 2>&1
php artisan config:clear >nul 2>&1
php artisan view:clear >nul 2>&1
echo Cache nettoye
echo.

echo [3/3] Demarrage du serveur...
echo.
echo ====================================
echo    SERVEUR DEMARRE
echo ====================================
echo.
echo L'application est disponible sur:
echo    http://localhost:8000
echo.
echo Appuyez sur Ctrl+C pour arreter le serveur
echo.
echo ====================================
echo.

php artisan serve --host=127.0.0.1 --port=8000

pause

