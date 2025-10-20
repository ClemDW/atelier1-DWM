<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;

interface OutilsRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): Outil;
    public function findCategorieById(int $id): Categorie;
}
