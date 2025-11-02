<?php

namespace charlymatloc\infra\repositories;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\domain\entities\Categorie;
use charlymatloc\core\domain\entities\Outil;
use charlymatloc\core\domain\entities\Outillage;
use charlymatloc\infra\exceptions\OutilNotFoundException;
use PDO;
use PDOException;

class OutilsRepository implements OutilsRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function findAllOutillages(): array
    {
        $sql = "SELECT * FROM outillage";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $outillages = [];
        foreach ($rows as $row) {
            $outillages[] = new Outillage(
                $row['id_outillage'],
                $row['id_categorie'],
                $row['nom_outillage'],
                $row['description'],
                $row['prix_journalier'],
                $row['image_url']
            );
        }
        return $outillages;
    }

    public function findOutillageById(int $id_outillage): Outillage
    {
        $sql = "SELECT * FROM outillage WHERE id_outillage = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_outillage, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $outillage = new Outillage(
            $row['id_outillage'],
            $row['id_categorie'],
            $row['nom_outillage'],
            $row['description'],
            $row['prix_journalier'],
            $row['image_url']
        );
        return $outillage;
    }

    public function calculateStock(int $id_outillage): int
    {
        $sql = "SELECT COUNT(*) AS stock
            FROM outils o
            WHERE o.id_outillage = :id_outillage";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outillage', $id_outillage, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['stock'];
    }

    public function findOutillagesByCategorie(int $categorieId): array
    {
        $sql = "SELECT * FROM outillage WHERE id_categorie = :categorieId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':categorieId', $categorieId, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $outillages = [];
        foreach ($rows as $row) {
            $outillages[] = new Outillage(
                $row['id_outillage'],
                $row['id_categorie'],
                $row['nom_outillage'],
                $row['description'],
                $row['prix_journalier'],
                $row['image_url']
            );
        }
        return $outillages;
    }

    public function findAllCategories(): array
    {
        $sql = "SELECT * FROM categorie";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $categories = [];
        foreach ($rows as $row) {
            $categories[] = new Categorie(
                $row['id_categorie'],
                $row['nom_categorie']
            );
        }
        return $categories;
    }

    public function checkAssezOutils(int $id_outillage, int $quantite): bool
    {
        $sql = "SELECT COUNT(*) AS stock
            FROM outils o
            WHERE o.id_outillage = :id_outillage";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outillage', $id_outillage, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stock = (int) $result['stock'];
        return $stock >= $quantite;
    }
}
