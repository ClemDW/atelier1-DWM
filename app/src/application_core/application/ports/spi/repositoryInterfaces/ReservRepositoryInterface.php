<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\Reservation;

interface ReservRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): Reservation;
    public function countReservedOutils(int $id_outil, string $date): int;
    public function findByUserAndStatut(string $userId, string $statut): array;
    public function createReservation(string $id_reservation, string $id_utiliateur, string $date_creation, string $statut, string $prix_total): Reservation;
    public function createReservOutil(string $id_reservation, string $id_outil, string $date_debut, string $date_fin);
    public function findOutilIdsByReservation(string $id_reservation): array;

}