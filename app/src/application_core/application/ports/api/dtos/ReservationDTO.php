<?php

namespace charlymatloc\core\application\ports\api\dtos;

class ReservationDTO
{
    public string $id_reservation;
    public string $id_utiliateur;
    public string $date_creation;
    public string $statut;
    public string $prix_total;

    public function __construct(string $id_reservation, string $id_utiliateur, string $date_creation, string $statut, string $prix_total){
        $this->id_reservation = $id_reservation;
        $this->id_utiliateur = $id_utiliateur;
        $this->date_creation = $date_creation;
        $this->statut = $statut;
        $this->prix_total = $prix_total;
    }
}