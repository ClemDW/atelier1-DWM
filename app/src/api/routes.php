<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutillageAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\ListerOutillagesAction;
use charlymatloc\api\middlewares\AuthnMiddleware;
use charlymatloc\api\middlewares\AuthzMiddleware;
use charlymatloc\api\middlewares\CreerCompteMiddleware;
use charlymatloc\api\actions\AjouterAuPanierAction;
use charlymatloc\api\actions\VerifierDisponibiliteAction;
use Slim\App;
use charlymatloc\api\actions\AfficherHistoriqueAction;

return function (App $app):App {

    $app->get('/outillages', ListerOutillagesAction::class)->setName('lister_outils');

    $app->get('/outillages/{id}', AfficherOutillageAction::class)->setName('afficher_outil');

$app->options('/users', function ($request, $response) {


        return $response;


    });
$app->options('/login', function ($request, $response) {


        return $response;


    });
    $app->get('/outils/{id}/disponibilite', VerifierDisponibiliteAction::class)->setName('verifier_disponibilite');

    $app->post('/panier/outils/{id}', AjouterAuPanierAction::class)->setName('ajouter_au_panier');

    $app->get('/historique', AfficherHistoriqueAction::class)
        ->add(AuthzMiddleware::class)
        ->setName('historique');




    return $app;
};
