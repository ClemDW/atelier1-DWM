<?php

namespace charlymatloc\core\domain\entities;

class Categorie
{
    private int $id_categorie;
    private string $nom_categorie;
    private string $description;
    private float $prix;
    private string $image;

    public function __construct(int $id_categorie, string $nom_categorie, string $description, float $prix, string $image) {
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }

    public function getIdCategorie(): int
    {
        return $this->id_categorie;
    }

    public function getNomCategorie(): string
    {
        return $this->nom_categorie;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}