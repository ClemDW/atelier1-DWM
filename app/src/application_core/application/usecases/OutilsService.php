<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\dtos\OutilListeDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;
use charlymatloc\core\application\ports\api\dtos\OutilAfficheDTO;

class OutilsService implements OutilsServiceInterface
{
    private OutilsRepositoryInterface $outilsRepository;
    private ReservRepositoryInterface $reservRepository;

    public function __construct(OutilsRepositoryInterface $outilsRepository, ReservRepositoryInterface $reservRepository){
        $this->outilsRepository = $outilsRepository;
        $this->reservRepository = $reservRepository;
    }


    public function ListerOutils(): array
    {
        $outils = $this->outilsRepository->findAll();
        $outilsDTO = [];
        foreach ($outils as $outil){
            $outilsDTO[] = new OutilListeDTO(
                $outil->getId(),
                $outil->getNom(),
                $outil->getImage(),
                $outil->getStock()
            );
        }
        return $outilsDTO;
    }

    public function AfficherOutil(string $id): OutilAfficheDTO
    {
        $outil = $this->outilsRepository->findById($id);
        $categorie = $this->outilsRepository->findCategorieById($outil->getIdCategorie());
        return new OutilAfficheDTO(
            $outil->getId(),
            $outil->getNom(),
            $outil->getImage(),
            $outil->getStock(),
            $outil->getDescription(),
            $categorie->getNom(),
            $outil->getPrix()
        );
    }

    public function isOutilDisponible(string $id_outil, string $date): bool
    {
        $outil = $this->outilsRepository->findById($id_outil);
        $stock = $outil->getStock();

        $reserved = $this->reservRepository->countReservedOutils($id_outil, $date);

        return ($stock - $reserved) > 0;
    }
}
