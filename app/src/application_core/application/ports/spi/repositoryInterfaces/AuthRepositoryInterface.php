<?php

namespace charlymatloc\core\application\ports\spi\repositoryInterfaces;

use charlymatloc\core\domain\entities\User;

interface AuthRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function create(string $id, string $email, string $password, string $nom, string $prenom): User;
}