<?php

namespace charlymatloc\infra\repositories;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;
use PDO;

class OutilsRepository implements OutilsRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function findAll(): array
    {
        $sql = "SELECT * FROM outils";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $outils = [];
        foreach ($rows as $row) {
            $outils[] = new Outil($row['id_outil'], $row['id_categorie'], $row['nom'], $row['description'], $row['prix_journalier'], $row['image_url']);
        }
        return $outils;
    }

    public function findById(int $id): Outil
    {
        $sql = "SELECT * FROM outils WHERE id_outil = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Outil($row['id_outil'], $row['id_categorie'], $row['nom'], $row['description'], $row['prix_journalier'], $row['image_url']);
    }

    public function findCategorieById(int $id): Categorie
    {
        $sql = "SELECT * FROM outils WHERE id_categorie = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Categorie($row['id_categorie'], $row['nom']);
    }
}