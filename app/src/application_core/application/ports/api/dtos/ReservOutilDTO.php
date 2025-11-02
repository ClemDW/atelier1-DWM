<?php

namespace charlymatloc\core\application\ports\api\dtos;

class ReservOutilDTO
{
    public string $id_reservation;
    public string $id_outil;
    public string $date_debut;
    public string $date_fin;

    public function __construct(string $id_reservation, string $id_outil, string $date_debut, string $date_fin){
        $this->id_reservation = $id_reservation;
        $this->id_outil = $id_outil;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
    }

}