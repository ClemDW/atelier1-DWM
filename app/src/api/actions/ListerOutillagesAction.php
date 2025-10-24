<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListerOutillagesAction{
    private OutilsServiceInterface $outilsService;
    public function __construct(OutilsServiceInterface $outilsService){
        $this->outilsService = $outilsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $queryParams = $request->getQueryParams();
        $categorieId = isset($queryParams['categorie']) ? (int)$queryParams['categorie'] : null;

        if ($categorieId !== null) {
            $outils = $this->outilsService->ListerOutillagesParCategorie($categorieId);
        } else {
            $outils = $this->outilsService->ListerOutillages();
        }

        $response->getBody()->write(json_encode($outils, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
