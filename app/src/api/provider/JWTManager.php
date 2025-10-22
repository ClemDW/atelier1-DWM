<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\UserDTO;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager{

    public function createAccessToken(array $payload): string{
        $payload['exp'] = time() + 15 * 60;
        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }

    public function createRefreshToken(array $payload): string{
        $payload['exp'] = time() + 7 * 24 * 60 * 60;
        $refreshToken = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        return $refreshToken;
    }

    public function decodeToken(string $token): UserDTO{
        $token = sscanf($token, 'Bearer %s');
        $payload = JWT::decode($token[1], new Key($_ENV['JWT_SECRET'], 'HS256'));
        $user = new UserDTO($payload->id, $payload->email, $payload->nom, $payload->prenom);
        return $user;
    }
}