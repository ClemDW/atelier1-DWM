<?php

namespace charlymatloc\core\application\ports\api\dtos;


class HistoriqueDTO
{
    public string $id;
    public string $user_id;
    public array $outils;
    public string $date_creation;
    public string $statut;
    public float $prix_total;

    public function __construct(
        string $id,
        string $user_id,
        array $outils,
        string $date_creation,
        string $statut,
        float $prix_total
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->outils = $outils;
        $this->date_creation = $date_creation;
        $this->statut = $statut;
        $this->prix_total = $prix_total;
    }
}