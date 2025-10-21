<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ConnecterAction{
    private AuthServiceInterface $authService;
    public function __construct(AuthServiceInterface $authService){
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response,array $args){

    }
}
