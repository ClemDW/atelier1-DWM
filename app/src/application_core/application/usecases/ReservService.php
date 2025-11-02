<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\dtos\ReservationDTO;
use charlymatloc\core\application\ports\api\dtos\ReservOutilDTO;
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

    public function registerReservation(ReservationDTO $reservationDTO): void
    {
        $this->reservRepository->createReservation(
            $reservationDTO->id_reservation,
            $reservationDTO->id_utiliateur,
            $reservationDTO->date_creation,
            $reservationDTO->statut,
            $reservationDTO->prix_total
        );
    }

    public function registerReservOutil(array $reservOutilDTOs): void
    {
        foreach ($reservOutilDTOs as $reservOutilDTO) {
            $this->reservRepository->createReservOutil(
                $reservOutilDTO->id_reservation,
                $reservOutilDTO->id_outil,
                $reservOutilDTO->date_debut,
                $reservOutilDTO->date_fin
            );
        }
    }
}

