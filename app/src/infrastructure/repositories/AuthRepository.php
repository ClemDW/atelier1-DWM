<?php

namespace charlymatloc\infra\repositories;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
use charlymatloc\core\domain\entities\User;
use PDO;

class AuthRepository implements AuthRepositoryInterface
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return new User($row['id'], $row['email'], $row['password'], $row['nom'], $row['prenom']);
    }

    public function create(string $id, string $email, string $password, string $nom, string $prenom): User
    {
        $sql = "INSERT INTO users (id, nom, prenom, email, password) VALUES (:id, :nom, :prenom, :email, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        return new User($id, $email, $password, $nom, $prenom);
    }
}