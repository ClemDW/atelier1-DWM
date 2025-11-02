<?php

namespace charlymatloc\core\domain\entities;

class Reservation
{
    private string $id;
    private string $user_id;
    private array $reserv_outils;
    private string $date_creation;
    private string $statut;
    private float $prix_total;

    public function __construct(string $id, string $user_id, array $reserv_outils, string $date_creation, string $statut, float $prix_total)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->reserv_outils = $reserv_outils;
        $this->date_creation = $date_creation;
        $this->statut = $statut;
        $this->prix_total = $prix_total;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function setReservOutils(array $reserv_outils): void
    {
        $this->reserv_outils = $reserv_outils;
    }

    public function getReservOutils(): array
    {
        return $this->reserv_outils;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getPrixTotal(): float
    {
        return $this->prix_total;
    }

}