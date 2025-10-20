<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\Reservation;

interface ReservRepositoryInterface
{
    public function findAll(): array;
    public function findById(string $id): Reservation;
    public function countReservedOutils(int $id_outil, string $date): int;
}