<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\core\application\usecases\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreerCompteAction{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args): ResponseInterface
    {
        try {
            $dto = $request->getAttribute('inputUserDTO');
            $this->authService->register($dto);
            $payload = ['success' => true, 'message' => 'Compte cree'];
            $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        } catch (Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Erreur lors de la création du compte'], JSON_PRETTY_PRINT));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}