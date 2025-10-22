<?php

namespace charlymatloc\api\middlewares;

use charlymatloc\core\application\ports\api\dtos\CredentialsDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthnMiddleware implements MiddlewareInterface{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $email = $payload['email'];
        $password = $payload['password'];
        if($email == null || $password == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Email ou mot de passe manquant');
            return $response->withStatus(400);
        }
        $credentials = new CredentialsDTO($email, $password);
        $request = $request->withAttribute('credentials', $credentials);
        return $handler->handle($request);
    }
}