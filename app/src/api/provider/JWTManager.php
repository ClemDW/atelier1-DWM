<?php

namespace charlymatloc\api\provider;

use Firebase\JWT\JWT;

class JWTManager{

    public function __construct(){

    }

    public function createAccessToken(array $payload): string{
        $payload['exp'] = time() + 15 * 60;
        return JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');
    }

    public function createRefreshToken(array $payload): string{
        $payload['exp'] = time() + 7 * 24 * 60 * 60;
        $refreshToken = JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');
        return $refreshToken;
    }

    public function decodeToken(string $token): array{
        return [];
    }
}