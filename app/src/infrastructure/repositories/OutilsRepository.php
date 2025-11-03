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
            WHERE o.id_outillage = :id_outillage
            AND o.disponible = true";

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
            WHERE o.id_outillage = :id_outillage
            AND o.disponible = true";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outillage', $id_outillage, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stock = (int) $result['stock'];
        return $stock >= $quantite;
    }

    public function outilsDisponibles(int $id_outillage): array
    {
        $sql = "SELECT *
            FROM outils o
            WHERE o.id_outillage = :id_outillage
            AND o.disponible = true";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outillage', $id_outillage, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $outils = [];
        foreach ($result as $row) {
            $outils[] = new Outil(
                $row['id_outil'],
                $row['id_outillage'],
                $row['disponible']
            );
        }
        return $outils;
    }

    public function findOutillageByOutilId(string $id_outil): ?array
    {
        $sql = "SELECT id_outillage, disponible FROM outils WHERE id_outil = :id_outil";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outil', $id_outil);
        $stmt->execute();
        $outil = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$outil) {
            return null;
        }

        $sql2 = "SELECT id_outillage, nom_outillage, description, prix_journalier, image_url
             FROM outillage WHERE id_outillage = :id_outillage";
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt2->bindParam(':id_outillage', $outil['id_outillage']);
        $stmt2->execute();
        $outillage = $stmt2->fetch(\PDO::FETCH_ASSOC);

        $outil['outillage'] = $outillage ?: [];

        return $outil;
    }

    public function setOutilStatus(string $id_outil, bool $disponible)
    {
        $dispoValue = $disponible ? '1' : '0';
        $sql = "UPDATE outils SET disponible = :disponible WHERE id_outil = :id_outil";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':disponible', $dispoValue, PDO::PARAM_BOOL);
        $stmt->bindParam(':id_outil', $id_outil, PDO::PARAM_STR);
        $stmt->execute();
    }
}
