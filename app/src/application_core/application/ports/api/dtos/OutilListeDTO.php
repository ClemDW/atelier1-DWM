<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutilListeDTO
{
    public string $nom;
    public string $image;

    public function __construct(string $nom, string $image){
        $this->nom = $nom;
        $this->image = $image;
    }
}
