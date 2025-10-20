DROP TABLE IF EXISTS categories;
CREATE TABLE public.categories (
    id_categorie SERIAL PRIMARY KEY,
    nom_categorie VARCHAR(100) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS outils;
CREATE TABLE public.outils (
    id_outil SERIAL PRIMARY KEY,
    id_categorie INTEGER NOT NULL REFERENCES Categories(id_categorie),
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    prix_journalier NUMERIC(10, 2) NOT NULL CHECK (prix_journalier > 0),
    image_url VARCHAR(255),
    stock INTEGER
);