<?php

namespace charlymatloc\core\application\ports\api\serviceinterfaces;

use charlymatloc\core\domain\entities\Reservation;

interface ReservServiceInterface
{
	public function getUserReservations(string $userId, string $status): array;
	public function getAllUserReservations(string $userId): array;
}