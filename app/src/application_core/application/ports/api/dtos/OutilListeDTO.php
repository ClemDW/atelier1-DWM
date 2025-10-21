<?php

namespace charlymatloc\core\application\ports\api\dtos;

class OutilListeDTO
{
    public int $id;
    public string $nom;
    public string $image;
    public int $stock;

    public function __construct(int $id, string $nom, string $image, int $stock){
        $this->id = $id;
        $this->nom = $nom;
        $this->image = $image;
        $this->stock = $stock;
    }
}
