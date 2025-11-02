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
        try {
            $header = $request->getHeaderLine('Authorization');
            $token = sscanf($header, 'Bearer %s')[0];
            if ($token == null) {
                $response = new \Slim\Psr7\Response();
                $response->getBody()->write('Token manquant');
                return $response->withStatus(400);
            }

            $user = $this->authnProvider->getSignedInUser($token);
            $id = $user->id;
            $request = $request->withAttribute('user', $user);
            return $handler->handle($request);
        } catch (\InvalidArgumentException $e){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Token invalide : ' . $e->getMessage());
            return $response->withStatus(401);
        } catch (\Exception $e){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Accès non autorisé : ' . $e->getMessage());
            return $response->withStatus(401);
        }
    }
}