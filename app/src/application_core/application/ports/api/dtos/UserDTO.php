<?php

namespace charlymatloc\core\application\ports\api\dtos;

class UserDTO
{
    public string $id;
    public string $email;
    public string $nom;
    public string $prenom;

    public function __construct(string $id, string $email, string $nom, string $prenom)
    {
        $this->id = $id;
        $this->email = $email;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

}