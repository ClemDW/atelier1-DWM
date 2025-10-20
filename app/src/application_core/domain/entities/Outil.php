<?php

namespace charlymatloc\core\domain\entities;

class Outil
{
    private int $id;
    private int $id_categorie;
    private string $nom;
    private string $description;
    private float $prix;
    private string $image;

    public function __construct(int $id, int $categorie, string $nom, string $description, float $prix, string $image){
        $this->id = $id;
        $this->id_categorie = $categorie;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }

    public function getId(): string{
        return $this->id;
    }
    public function getIdCategorie(): string{
        return $this->id_categorie;
    }
    public function getNom(): string{
        return $this->nom;
    }
    public function getDescription(): string{
        return $this->description;
    }
    public function getPrix(): float{
        return $this->prix;
    }
    public function getImage(): string{
        return $this->image;
    }
}