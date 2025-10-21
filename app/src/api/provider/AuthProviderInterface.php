<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;

interface AuthProviderInterface{
    public function signin(CredentialsDTO $credentials);
}