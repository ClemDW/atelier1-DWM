DROP TABLE IF EXISTS public.reservations CASCADE;
CREATE TABLE public.reservations (
    id_reservation uuid PRIMARY KEY,
    id_utilisateur uuid NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    date_creation TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) NOT NULL DEFAULT 'En attente',
    prix_total NUMERIC(10, 2) NOT NULL CHECK (prix_total >= 0),

    -- Contrainte pour s'assurer que la date de début est avant la date de fin
    CONSTRAINT chk_date_range CHECK (date_debut <= date_fin)
);

DROP TABLE IF EXISTS public.reservation_outils CASCADE;
CREATE TABLE public.reservation_outils (
    id_reservation uuid REFERENCES reservations(id_reservation) ON DELETE CASCADE,
    id_outil INTEGER REFERENCES outils(id_outil) ON DELETE CASCADE,
    quantite INTEGER NOT NULL DEFAULT 1 CHECK (quantite > 0),
    PRIMARY KEY (id_reservation, id_outil)
);
