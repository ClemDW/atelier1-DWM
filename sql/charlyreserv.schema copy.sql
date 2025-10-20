DROP TABLE IF EXISTS "reservations";
CREATE TABLE "public"."reservations" (
    id_reservation SERIAL PRIMARY KEY,
    id_utilisateur INTEGER NOT NULL REFERENCES Utilisateurs(id_utilisateur),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    date_creation TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) NOT NULL DEFAULT 'Confirmée',
    prix_total NUMERIC(10, 2) NOT NULL CHECK (prix_total >= 0),
    
    -- Contrainte pour s'assurer que la date de début est avant la date de fin
    CONSTRAINT chk_date_range CHECK (date_debut <= date_fin)
);

