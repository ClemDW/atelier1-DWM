<?php

namespace charlymatloc\core\application\ports\api\serviceinterfaces;

use charlymatloc\core\application\ports\api\dtos\ReservationDTO;
use charlymatloc\core\domain\entities\Reservation;

interface ReservServiceInterface
{
	public function getUserReservations(string $userId, string $status): array;
	public function getAllUserReservations(string $userId): array;
    public function registerReservation(ReservationDTO $reservationDTO): void;
    public function registerReservOutil(array $reservOutilDTOs): void;
}