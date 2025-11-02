<?php

namespace charlymatloc\infra\repositories;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;
use charlymatloc\core\domain\entities\Reservation;
use DateTime;
use DateTimeZone;
use PDO;
use PDOException;

class ReservRepository implements ReservRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM reservations";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reservations = [];
        foreach ($rows as $row) {
            // Get outils for this reservation
            $outils = $this->getOutilsForReservation($row['id_reservation']);
            $reservations[] = new Reservation(
                $row['id_reservation'],
                $row['id_utilisateur'],
                $outils,
                $row['date_creation'],
                $row['statut'],
                $row['prix_total']
            );
        }
        return $reservations;
    }

    public function findById(string $id): Reservation
    {
        $sql = "SELECT * FROM reservations WHERE id_reservation = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            throw new \Exception("Reservation not found");
        }
        $outils = $this->getOutilsForReservation($row['id_reservation']);
        return new Reservation(
            $row['id_reservation'],
            $row['id_utilisateur'],
            $outils,
            $row['date_creation'],
            $row['statut'],
            $row['prix_total']
        );
    }

    public function countReservedOutils(int $id_outil, string $date): int
    {
        $sql = "SELECT SUM(quantite) as total FROM reservation_outils ro
                JOIN reservations r ON ro.id_reservation = r.id_reservation
                WHERE ro.id_outil = :id_outil AND :date BETWEEN r.date_debut AND r.date_fin
                AND r.statut IN ('En attente', 'Validé')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_outil', $id_outil, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    private function getOutilsForReservation(string $id_reservation): array
    {
        $sql = "SELECT id_outil FROM reservation_outils WHERE id_reservation = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_reservation, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $outils = [];
        foreach ($rows as $row) {
            $outils[] = [
                'id_outil' => $row['id_outil'],
            ];
        }
        return $outils;
    }

    public function findByUserAndStatut(string $userId, string $statut): array
    {
        $sql = "SELECT * FROM reservations WHERE id_utilisateur = :userId AND statut = :statut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reservations = [];
        foreach ($rows as $row) {
            $outils = $this->getOutilsForReservation($row['id_reservation']);
            $dt = new DateTime($row['date_creation'], new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone('Europe/Paris'));
            $dateFormatee = $dt->format('d/m/Y H:i');
            $reservations[] = new Reservation(
                $row['id_reservation'],
                $row['id_utilisateur'],
                $outils,
                $dateFormatee,
                $row['statut'],
                $row['prix_total']
            );
        }
        return $reservations;
    }

    public function findOutilIdsByReservation(string $id_reservation): array
    {
        $sql = "SELECT id_outil FROM reservation_outils WHERE id_reservation = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_reservation);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_column($rows, 'id_outil');
    }
}
