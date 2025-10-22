<?php

namespace charlymatloc\api\middlewares;

use charlymatloc\core\application\ports\api\dtos\InputUserDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreerCompteMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $payload = $request->getParsedBody();
        $nom = $payload['nom'];
        if($nom == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Nom manquant');
            return $response->withStatus(400);
        }

        $prenom = $payload['prenom'];
        if($prenom == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Prenom manquant');
            return $response->withStatus(400);
        }

        $email = $payload['email'];
        if($email == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Email manquant');
            return $response->withStatus(400);
        }
        $password = $payload['password'];
        if($password == null){
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Password manquant');
            return $response->withStatus(400);
        }

        $nom = htmlspecialchars($nom);
        $prenom = htmlspecialchars($prenom);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Email invalide');
            return $response->withStatus(400);
        }
        $password = password_hash($password, PASSWORD_DEFAULT);

        $dto = new InputUserDTO($email, $password, $nom, $prenom);
        $request = $request->withAttribute('inputUserDTO', $dto);
        return $handler->handle($request);
    }
}