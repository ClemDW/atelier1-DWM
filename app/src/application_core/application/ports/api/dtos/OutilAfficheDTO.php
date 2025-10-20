<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutilAfficheDTO
{
    public string $nom;
    public string $image;
    public string $description;
    public string $categorie;
    public float $prix;

    public function __construct(string $nom, string $image, string $description, string $categorie, float $prix){
        $this->nom = $nom;
        $this->image = $image;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->prix = $prix;
    }
}