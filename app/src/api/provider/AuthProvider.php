<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;

class AuthProvider implements AuthProviderInterface
{
    private AuthServiceInterface $authService;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }
    public function signin(CredentialsDTO $credentials)
    {
        $user = $this->authService->byCredentials($credentials);

    }
}