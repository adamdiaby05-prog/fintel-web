# Script rapide pour créer la table admins IMMÉDIATEMENT

Write-Host "Création de la table admins..." -ForegroundColor Cyan

# Créer la table admins
psql -U postgres -d fintel -c @"
CREATE TABLE IF NOT EXISTS admins (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_admins_email ON admins(email);
INSERT INTO admins (email, password, first_name, last_name, is_active)
VALUES (
    'admin@fintel.com',
    '\$2y\$12\$TEDczrlagGIWW.T.4k3kl.fw7ka.x/4GuHNV0PZ6saI36DfOZpsGi',
    'Admin',
    'Fintel',
    TRUE
)
ON CONFLICT (email) DO NOTHING;
SELECT 'Table admins créée avec succès!' as message;
"@

Write-Host ""
Write-Host "Terminé!" -ForegroundColor Green
Write-Host "Vous pouvez maintenant vous connecter à:" -ForegroundColor Cyan
Write-Host "  http://localhost:8000/admin/login" -ForegroundColor White
Write-Host "  Email: admin@fintel.com" -ForegroundColor White
Write-Host "  Mot de passe: admin123" -ForegroundColor White

