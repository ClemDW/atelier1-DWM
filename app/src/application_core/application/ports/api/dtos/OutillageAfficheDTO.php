<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutillageAfficheDTO
{
    public string $id_categorie;
    public string $nom_outillage;

    public string $description;
    public string $image;
    public float $prix;

    public function __construct(string $id_outillage, string $nom_outillage, string $description, float $prix, string $image){
        $this->id_categorie = $id_outillage;
        $this->nom_outillage = $nom_outillage;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }
}