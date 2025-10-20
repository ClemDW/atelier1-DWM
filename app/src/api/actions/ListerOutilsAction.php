<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListerOutilsAction{
    private OutilsServiceInterface $outilsService;
    public function __construct(OutilsServiceInterface $outilsService){
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $outils = $this->outilsService->ListerOutils();

        $response->getBody()->write(json_encode($outils, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
