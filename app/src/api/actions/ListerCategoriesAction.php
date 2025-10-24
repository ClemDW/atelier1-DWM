<?php

namespace charlymatloc\api\actions;

use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListerCategoriesAction{
    private OutilsRepositoryInterface $outilsRepository;
    public function __construct(OutilsRepositoryInterface $outilsRepository){
        $this->outilsRepository = $outilsRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        $categories = $this->outilsRepository->findAllCategories();

        $categoriesData = array_map(function($categorie) {
            return [
                'id_categorie' => $categorie->getIdCategorie(),
                'nom_categorie' => $categorie->getNomCategorie()
            ];
        }, $categories);

        $response->getBody()->write(json_encode($categoriesData, JSON_PRETTY_PRINT));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
