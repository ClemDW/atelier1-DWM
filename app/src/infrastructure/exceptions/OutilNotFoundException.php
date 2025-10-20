<?php

namespace charlymatloc\infra\exceptions;

class OutilNotFoundException extends \Exception{
    public function __construct(int $id)
    {
        parent::__construct("L'outil avec l'ID $id n'existe pas", 404);
    }

}