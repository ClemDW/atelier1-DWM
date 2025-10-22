<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;

interface AuthnProviderInterface{
    public function signin(CredentialsDTO $credentials);
}