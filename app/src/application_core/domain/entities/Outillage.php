<?php

namespace charlymatloc\core\domain\entities;

class Outillage
{
    private int $id_outillage;
    private int $id_categorie;
    private string $nom_outillage;
    private string $description;
    private float $prix_journalier;
    private string $image_url;

    public function __construct(int $id_outillage, int $id_categorie, string $nom_outillage, string $description, float $prix_journalier, string $image_url)
    {
        $this->id_outillage = $id_outillage;
        $this->id_categorie = $id_categorie;
        $this->nom_outillage = $nom_outillage;
        $this->description = $description;
        $this->prix_journalier = $prix_journalier;
        $this->image_url = $image_url;
    }

    public function getIdOutillage(): int
    {
        return $this->id_outillage;
    }

    public function getIdCategorie(): int
    {
        return $this->id_categorie;
    }

    public function getNomOutillage(): string
    {
        return $this->nom_outillage;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrixJournalier(): float
    {
        return $this->prix_journalier;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

}