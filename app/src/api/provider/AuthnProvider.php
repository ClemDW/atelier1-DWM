<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;
use charlymatloc\core\application\ports\api\dtos\UserDTO;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\api\provider\JWTManager;

class AuthnProvider implements AuthnProviderInterface
{
    private AuthServiceInterface $authService;
    private JWTManager $jwtManager;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
        $this->jwtManager = new JWTManager();
    }
    public function signin(CredentialsDTO $credentials)
    {
        $user = $this->authService->byCredentials($credentials);
        $user = json_encode($user);
        $accessToken = $this->jwtManager->createAccessToken((array)$user);
        $refreshToken = $this->jwtManager->createRefreshToken((array)$user);
        return [
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    public function getSignedInUser(string $token): UserDTO
    {
        $user = $this->jwtManager->decodeToken($token);
        return $user;
    }
}