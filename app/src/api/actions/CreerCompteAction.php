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
        $dto = $request->getAttribute('inputUserDTO');
        $this->authService->register($dto);
        $payload = ['success' => true, 'message' => 'Compte créé'];
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}