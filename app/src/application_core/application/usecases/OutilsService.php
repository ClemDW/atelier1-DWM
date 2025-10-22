<?php

namespace charlymatloc\core\application\usecases;

use charlymatloc\core\application\ports\api\dtos\CategorieListeDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;
use charlymatloc\core\application\ports\api\dtos\CategorieAfficheDTO;

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
        $categories = $this->outilsRepository->findAllCategories();
        $categoriesDTO = [];

        foreach ($categories as $categorie) {
            $stock = $this->outilsRepository->calculateStock($categorie->getIdCategorie());

            $categoriesDTO[] = new CategorieListeDTO(
                $categorie->getIdCategorie(),
                $categorie->getNomCategorie(),
                $categorie->getImage(),
                $stock
            );
        }

        return $categoriesDTO;
    }

    public function AfficherOutil(string $id): CategorieAfficheDTO
    {
        $outil = $this->outilsRepository->findCategorieById($id);
        return new CategorieAfficheDTO(
            $outil->getIdCategorie(),
            $outil->getNomCategorie(),
            $outil->getDescription(),
            $outil->getPrix(),
            $outil->getImage()
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
