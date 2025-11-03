<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\dtos\OutillageAfficheDTO;
use charlymatloc\core\application\ports\api\dtos\OutillageListeDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;

class OutilsService implements OutilsServiceInterface
{
    private OutilsRepositoryInterface $outilsRepository;

    public function __construct(OutilsRepositoryInterface $outilsRepository){
        $this->outilsRepository = $outilsRepository;
    }


    public function ListerOutillages(): array
    {
        $outillages = $this->outilsRepository->findAllOutillages();
        $outillagesDTO = [];

        foreach ($outillages as $outillage) {
            $stock = $this->outilsRepository->calculateStock($outillage->getIdOutillage());

            $outillagesDTO[] = new OutillageListeDTO(
                $outillage->getIdOutillage(),
                $outillage->getNomOutillage(),
                $outillage->getImageUrl(),
                $stock
            );
        }

        return $outillagesDTO;
    }

    public function ListerOutillagesParCategorie(int $categorieId): array
    {
        $outillages = $this->outilsRepository->findOutillagesByCategorie($categorieId);
        $outillagesDTO = [];

        foreach ($outillages as $outillage) {
            $stock = $this->outilsRepository->calculateStock($outillage->getIdOutillage());

            // Only include articles with available stock
            if ($stock > 0) {
                $outillagesDTO[] = new OutillageListeDTO(
                    $outillage->getIdOutillage(),
                    $outillage->getNomOutillage(),
                    $outillage->getImageUrl(),
                    $stock
                );
            }
        }

        return $outillagesDTO;
    }

    public function AfficherOutillage(string $id): OutillageAfficheDTO
    {
        $outillage = $this->outilsRepository->findOutillageById($id);
        return new OutillageAfficheDTO(
            $outillage->getIdOutillage(),
            $outillage->getNomOutillage(),
            $outillage->getDescription(),
            $outillage->getPrixJournalier(),
            $outillage->getImageUrl()
        );
    }

    public function checkAssezOutils(int $id_outillage, int $quantite): bool
    {
        return $this->outilsRepository->checkAssezOutils($id_outillage, $quantite);
    }

    public function getOutilsDisponibles(int $id_outillage): array
    {
        return $this->outilsRepository->outilsDisponibles($id_outillage);
    }

    public function setOutilStatus(string $id_outil, bool $disponible): void
    {
        $this->outilsRepository->setOutilStatus($id_outil, $disponible);
    }
}
