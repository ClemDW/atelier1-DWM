<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutilListeDTO
{
    public string $nom;
    public string $image;
    public int $stock;

    public function __construct(string $nom, string $image, int $stock){
        $this->nom = $nom;
        $this->image = $image;
        $this->stock = $stock;
    }
}
