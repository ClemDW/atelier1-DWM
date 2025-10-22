<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;

interface OutilsRepositoryInterface
{

    // Outils //

    public function findById(string $id): Outil;

    // Catégories //

    public function findAllCategories(): array;
    public function findCategorieById(int $id): Categorie;
    public function calculateStock(int $id_categorie): int;

}
