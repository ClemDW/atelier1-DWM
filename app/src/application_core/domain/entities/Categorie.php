<?php

namespace charlymatloc\core\domain\entities;

class Categorie
{
    private int $id_categorie;
    private string $nom_categorie;

    public function __construct(int $id_categorie, string $nom_categorie) {
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
    }

    public function getIdCategorie(): int
    {
        return $this->id_categorie;
    }

    public function getNomCategorie(): string
    {
        return $this->nom_categorie;
    }
}