<?php

namespace charlymatloc\api\provider;

use charlymatloc\core\application\ports\api\dtos\UserDTO;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTManager{

    public function createAccessToken(array $p): string{
        $payload['user'] = [
            'id' => $p['id'],
            'email' => $p['email'],
            'nom' => $p['nom'],
            'prenom' => $p['prenom']
        ];
        $payload['exp'] = time() + 15 * 60;
        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }

    public function createRefreshToken(array $payload): string{
        $payload['exp'] = time() + 7 * 24 * 60 * 60;
        $refreshToken = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        return $refreshToken;
    }

    public function decodeToken(string $token): UserDTO{
        try {
            $token = trim($token);

            if (str_starts_with($token, 'Bearer ')) {
                $token = substr($token, 7);
            }

            if (empty($token)) {
                throw new \InvalidArgumentException('Token cannot be empty');
            }

            $payload = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            $payloadUser = $payload->user;
            if($payloadUser->id === null || $payloadUser->email === null || $payloadUser->nom === null || $payloadUser->prenom === null){
                throw new \InvalidArgumentException('Token payload is missing required user information');
            }
            $user = new UserDTO(
                $payloadUser->id,
                $payloadUser->email,
                $payloadUser->nom,
                $payloadUser->prenom
            );

            return $user;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid token: ' . $e->getMessage());
        }
    }
}