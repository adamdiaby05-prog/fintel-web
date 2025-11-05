-- Script SQL pour créer la table admin dans PostgreSQL
-- Exécutez ce script dans votre base de données fintel

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

-- Créer un index sur l'email pour les recherches rapides
CREATE INDEX IF NOT EXISTS idx_admins_email ON admins(email);

-- Insérer un administrateur par défaut (mot de passe: admin123)
-- L'email et le mot de passe peuvent être changés après
INSERT INTO admins (email, password, first_name, last_name, is_active)
VALUES (
    'admin@fintel.com',
    '$2y$12$rwf1leBBp7lVLNrGDWO2PuFT2.Y9GpkRd1CdllLGqwVMq1li8ta6K', -- admin123
    'Admin',
    'Fintel',
    TRUE
)
ON CONFLICT (email) DO NOTHING;

-- Afficher le résultat
SELECT 'Table admins créée avec succès!' as message;
SELECT * FROM admins;

