<?php

namespace charlymatloc\core\domain\entities;

class Outil
{
    private string $id_outil;
    private int $id_outillage;
    private bool $disponible;


    public function __construct(string $id_outil, int $id_outillage, bool $disponible){
        $this->id_outil = $id_outil;
        $this->id_outillage = $id_outillage;
        $this->disponible = $disponible;
    }

    public function getIdOutil(): string{
        return $this->id_outil;
    }

    public function getIdOutillage(): int{
        return $this->id_outillage;
    }

    public function isDisponible(): bool{
        return $this->disponible;
    }

}