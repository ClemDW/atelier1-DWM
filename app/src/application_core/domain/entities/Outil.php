<?php

namespace charlymatloc\core\domain\entities;

class Outil
{
    private string $id;
    private int $id_categorie;
    private string $nom;
    private string $description;
    private float $prix;
    private string $image;
    private int $stock;

    public function __construct(string $id, int $categorie, string $nom, string $description, float $prix, string $image, int $stock){
        $this->id = $id;
        $this->id_categorie = $categorie;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
        $this->stock = $stock;
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
    public function getStock(): int{
        return $this->stock;
    }
}