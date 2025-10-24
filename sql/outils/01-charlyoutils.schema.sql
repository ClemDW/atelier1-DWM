DROP TABLE IF EXISTS outils CASCADE;
DROP TABLE IF EXISTS outillages CASCADE;
DROP TABLE IF EXISTS categorie CASCADE;

CREATE TABLE public.categorie (
    id_categorie SERIAL PRIMARY KEY NOT NULL,
    nom_categorie VARCHAR(100)
);

CREATE TABLE public.outillage (
    id_outillage SERIAL PRIMARY KEY NOT NULL,
    id_categorie INTEGER NOT NULL REFERENCES categorie(id_categorie),
    nom_outillage VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    prix_journalier NUMERIC(10, 2) NOT NULL CHECK (prix_journalier > 0),
    image_url VARCHAR(255)
);

CREATE TABLE public.outils (
    id_outil uuid PRIMARY KEY NOT NULL,
    id_outillage INTEGER NOT NULL REFERENCES outillage(id_outillage),
    disponible BOOLEAN DEFAULT TRUE
);

