<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;

class ReservService{
    private ReservRepositoryInterface $reservRepository;

    public function __construct(ReservRepositoryInterface $reservRepository){
        $this->reservRepository = $reservRepository;
    }

    public function ajoutReservation(){

    }
}