<?php

 namespace charlymatloc\infra\exceptions;

 class CategorieNotFoundException extends \Exception{
     public function __construct(int $id)
     {
         parent::__construct("Categorie with id $id not found.", 404);
     }
 }