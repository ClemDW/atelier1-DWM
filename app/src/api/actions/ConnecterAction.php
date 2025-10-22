<?php

namespace charlymatloc\api\actions;

use charlymatloc\api\provider\AuthnProvider;
use charlymatloc\api\provider\AuthnProviderInterface;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ConnecterAction{
    private AuthServiceInterface $authService;
    private AuthnProviderInterface $authnProvider;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
        $this->authnProvider = new AuthnProvider($authService);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args){
        $payload = $this->authnProvider->signin($request->getAttribute('credentials'));
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
