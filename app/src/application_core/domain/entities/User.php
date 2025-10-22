<?php

namespace charlymatloc\core\domain\entities;

class User
{
    private string $id;
    private string $email;
    private string $password;
    private string $nom;
    private string $prenom;

    public function __construct(string $id, string $email, string $password, string $nom, string $prenom){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    public function getId(): string{
        return $this->id;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }

    public function getNom(): string{
        return $this->nom;
    }
    public function getPrenom(): string{
        return $this->prenom;
    }



}
