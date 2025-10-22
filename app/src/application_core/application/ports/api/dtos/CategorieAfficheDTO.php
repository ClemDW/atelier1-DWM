<?php

namespace charlymatloc\core\application\ports\api\dtos;

class CategorieAfficheDTO
{
    public string $id_categorie;
    public string $nom_categorie;

    public string $description;
    public string $image;
    public float $prix;

    public function __construct(string $id_categorie, string $nom_categorie, string $description, float $prix, string $image){
        $this->id_categorie = $id_categorie;
        $this->nom_categorie = $nom_categorie;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }
}