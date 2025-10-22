<?php

namespace charlymatloc\api\middlewares;

use charlymatloc\api\provider\AuthnProvider;
use charlymatloc\core\application\usecases\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthzMiddleware implements MiddlewareInterface
{
    private AuthnProvider $authnProvider;

    public function __construct(AuthnProvider $authnProvider){
        $this->authnProvider = $authnProvider;
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $token = $payload['access_token'];
        if($token == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Token manquant');
            return $response->withStatus(400);
        }

        $user = $this->authnProvider->getSignedInUser($token);
        $request = $request->withAttribute('user', $user);
        return $handler->handle($request);
    }
}