# Script pour corriger le mot de passe admin

Write-Host "Correction du mot de passe admin..." -ForegroundColor Cyan

psql -U postgres -d fintel -c "UPDATE admins SET password = '\$2y\$12\$Bz7GcTrAULjN8ebWzbP/ZuQtSC64P7KMs4baP2C5oSEQTrarziT1u' WHERE email = 'admin@fintel.com'; SELECT id, email, first_name FROM admins;"

Write-Host ""
Write-Host "Mot de passe corrigé!" -ForegroundColor Green
Write-Host "Vous pouvez maintenant vous connecter avec:" -ForegroundColor Cyan
Write-Host "  Email: admin@fintel.com" -ForegroundColor White
Write-Host "  Mot de passe: admin123" -ForegroundColor White

