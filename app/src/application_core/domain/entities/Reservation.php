<?php

namespace charlymatloc\core\domain\entities;

class Reservation
{
    private string $id;
    private string $user_id;
    private array $outils;
    private string $date_debut;
    private string $date_fin;
    private string $date_creation;
    private string $statut;
    private float $prix_total;

    public function __construct(string $id, string $user_id, array $outils, string $date_debut, string $date_fin, string $date_creation, string $statut, float $prix_total)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->outils = $outils;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
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

    public function getOutils(): array
    {
        return $this->outils;
    }

    public function getDateDebut(): string
    {
        return $this->date_debut;
    }

    public function getDateFin(): string
    {
        return $this->date_fin;
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