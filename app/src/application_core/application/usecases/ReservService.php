<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;

class ReservService implements ReservServiceInterface
{
    private ReservRepositoryInterface $reservRepository;

    public function __construct(ReservRepositoryInterface $reservRepository)
    {
        $this->reservRepository = $reservRepository;
    }

    public function getUserReservations(string $userId, string $status): array
    {
        return $this->reservRepository->findByUserAndStatut($userId, $status);
    }

    public function getAllUserReservations(string $userId): array
    {
        $all = $this->reservRepository->findAll();
        $result = [];
        foreach ($all as $r) {
            $rid = method_exists($r, 'getUserId') ? $r->getUserId() : ($r->user_id ?? null);
            if (strtolower(trim((string)$rid)) === strtolower(trim((string)$userId))) {
                $result[] = $r;
            }
        }
        return $result;
    }
}

