<?php

namespace charlymatloc\core\application\ports\api\serviceinterfaces;

use charlymatloc\core\application\ports\api\dtos\OutillageAfficheDTO;

interface OutilsServiceInterface
{
    public function ListerOutillages(): array;
    public function ListerOutillagesParCategorie(int $categorieId): array;
    public function AfficherOutillage(string $id): OutillageAfficheDTO;
    //public function isOutilDisponible(string $id_outil, string $date): bool; a voir plus tard
    public function checkAssezOutils(int $id_outillage, int $quantite): bool;
    public function getOutilsDisponibles(int $id_outillage): array;
}
