DROP TABLE IF EXISTS users;
CREATE TABLE public.users (
    id uuid NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email character varying(128) NOT NULL,
    password character varying(256) NOT NULL,
    CONSTRAINT users_email UNIQUE (email),
    CONSTRAINT users_id PRIMARY KEY (id)
) WITH (oids = false);