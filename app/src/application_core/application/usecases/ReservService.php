<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;
use charlymatloc\core\domain\entities\Reservation;

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
        $result = [];

        foreach ($reservations as $reservation) {
            $outilIds = $this->reservRepository->findOutilIdsByReservation($reservation->getId());
            $outils = [];

            foreach ($outilIds as $id_outil) {
                $outil = $this->outilsRepository->findOutillageByOutilId($id_outil);
                if ($outil) {
                    $outils[] = $outil;
                }
            }

            $result[] = new Reservation(
                $reservation->getId(),
                $reservation->getUserId(),
                $outils,
                $reservation->getDateCreation(),
                $reservation->getStatut(),
                $reservation->getPrixTotal()
            );
        }

        return $result;
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

