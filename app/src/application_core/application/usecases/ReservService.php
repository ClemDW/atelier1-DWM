<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;

class ReservService implements ReservServiceInterface
{
    private ReservRepositoryInterface $reservRepository;
    private OutilsRepositoryInterface $outilsRepository;

    public function __construct(ReservRepositoryInterface $reservRepository, OutilsRepositoryInterface $outilsRepository) {
        $this->reservRepository = $reservRepository;
        $this->outilsRepository = $outilsRepository;
    }


    public function getUserReservations(string $userId, string $statut): array
    {
        $reservations = $this->reservRepository->findByUserAndStatut($userId, $statut);

        foreach ($reservations as $reservation) {
            $outilIds = $this->reservRepository->findOutilIdsByReservation($reservation->getId());
            $outils = $this->outilsRepository->findOutilsByIds($outilIds);
            $reservation->setReservOutils($outils);
        }

        return $reservations;
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

