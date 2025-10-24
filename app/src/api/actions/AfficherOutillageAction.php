<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AfficherOutillageAction{
    private OutilsServiceInterface $outilsService;
    public function __construct(OutilsServiceInterface $outilsService){
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $outil = $this->outilsService->AfficherOutillage($request->getAttribute('id'));
        $response->getBody()->write(json_encode($outil, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
