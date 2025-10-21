<?php

namespace charlymatloc\core\application\ports\api\serviceinterfaces;

use charlymatloc\core\application\ports\api\dtos\OutilAfficheDTO;
use charlymatloc\core\application\ports\api\dtos\OutilListeDTO;

interface OutilsServiceInterface
{
    public function ListerOutils(): array;
    public function AfficherOutil(string $id): OutilAfficheDTO;
    public function isOutilDisponible(string $id_outil, string $date): bool;
}
