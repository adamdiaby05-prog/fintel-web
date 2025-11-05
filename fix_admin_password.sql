-- Script SQL pour corriger le mot de passe admin
-- Mot de passe: admin123
-- Hash Bcrypt généré par Laravel

UPDATE admins 
SET password = '$2y$12$rwf1leBBp7lVLNrGDWO2PuFT2.Y9GpkRd1CdllLGqwVMq1li8ta6K'
WHERE email = 'admin@fintel.com';

-- Vérifier la mise à jour
SELECT id, email, first_name, last_name FROM admins;

