<?php

namespace charlymatloc\infra\repositories;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;
use charlymatloc\infra\exceptions\OutilNotFoundException;
use PDO;
use PDOException;

class OutilsRepository implements OutilsRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function findAllCategories(): array
    {
        $sql = "SELECT 
        c.id_categorie, 
        c.nom_categorie, 
        c.description, 
        c.prix_journalier, 
        c.image_url
        FROM categories c";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $outils = [];
        foreach ($rows as $row) {
            $outils[] = new Categorie( $row['id_categorie'], $row['nom_categorie'], $row['description'], $row['prix_journalier'], $row['image_url']);
        }
        return $outils;
    }


    public function findById(string $id): Outil
    {
        $sql = "SELECT 
        o.id_outil,
        o.id_categorie, 
        o.nom, 
        o.description, 
        o.prix_journalier, 
        o.image_url,
        (SELECT COUNT(*) FROM outils o2 WHERE o2.id_categorie = o.id_categorie) as stock
    FROM outils o WHERE id_outil = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row ===false) {
            throw new OutilNotFoundException($id);
        }
        return new Outil($row['id_outil'], $row['id_categorie'], $row['nom'], $row['description'], $row['prix_journalier'], $row['image_url'], $row['stock']);
    }

    public function findCategorieById(int $id): Categorie
    {
        $sql = "SELECT * FROM categories WHERE id_categorie = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            throw new OutilNotFoundException($id);
        }
        return new Categorie($row['id_categorie'], $row['nom_categorie'], $row['description'], $row['prix_journalier'], $row['image_url']);
    }

    public function calculateStock(int $id_categorie): int
    {
        $sql = "SELECT COUNT(o.id_categorie) AS stock
            FROM outils o
            WHERE o.id_categorie = :id_categorie";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['stock'];
    }

}