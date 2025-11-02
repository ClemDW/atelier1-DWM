<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;
use charlymatloc\core\domain\entities\Outillage;

interface OutilsRepositoryInterface
{

    // Outillages //
    //public function calculateStock(int $id_outillage): int; a voir plus tard
    public function findAllOutillages(): array;
    public function findOutillageById(int $id_outillage): Outillage;
    public function findOutillagesByCategorie(int $categorieId): array;
    public function findOutilsByIds(array $ids): array;

    // Categories //
    public function findAllCategories(): array;

}
