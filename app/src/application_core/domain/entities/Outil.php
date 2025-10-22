<?php

namespace charlymatloc\core\domain\entities;

class Outil
{
    private string $id_outil;
    private int $id_categorie;


    public function __construct(string $id_outil, int $id_categorie){
        $this->id_outil = $id_outil;
        $this->id_categorie = $id_categorie;
    }

    public function getIdOutil(): string{
        return $this->id_outil;
    }

    public function getIdCategorie(): int{
        return $this->id_categorie;
    }

}