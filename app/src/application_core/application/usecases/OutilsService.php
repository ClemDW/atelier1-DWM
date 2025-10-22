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
    private ReservRepositoryInterface $reservRepository;

    public function __construct(OutilsRepositoryInterface $outilsRepository, ReservRepositoryInterface $reservRepository){
        $this->outilsRepository = $outilsRepository;
        $this->reservRepository = $reservRepository;
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

    /**  a  voir plus tard
    public function isOutilDisponible(string $id_outil, string $date): bool
    {
        $outil = $this->outilsRepository->findById($id_outil);
        $stock = $outil->getStock();

        $reserved = $this->reservRepository->countReservedOutils($id_outil, $date);

        return ($stock - $reserved) > 0;
    }
     */
}
