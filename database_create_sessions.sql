-- Script SQL pour créer la table sessions dans PostgreSQL
-- Les sessions Laravel utilisent cette table pour stocker les données de session

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);

-- Créer les index pour améliorer les performances
CREATE INDEX IF NOT EXISTS idx_sessions_user_id ON sessions(user_id);
CREATE INDEX IF NOT EXISTS idx_sessions_last_activity ON sessions(last_activity);

-- Afficher le résultat
SELECT 'Table sessions créée avec succès!' as message;

