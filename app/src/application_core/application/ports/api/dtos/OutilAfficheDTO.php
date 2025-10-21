<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutilAfficheDTO
{
    public string $id;
    public string $nom;
    public string $image;
    public int $stock;
    public string $description;
    public string $categorie;
    public float $prix;

    public function __construct(string $id, string $nom, string $image, int $stock, string $description, string $categorie, float $prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->image = $image;
        $this->stock = $stock;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->prix = $prix;
    }
}