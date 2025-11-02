<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutillageAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\CreerReservation;
use charlymatloc\api\actions\ListerOutillagesAction;
use charlymatloc\api\actions\ListerCategoriesAction;
use charlymatloc\api\middlewares\AuthnMiddleware;
use charlymatloc\api\middlewares\AuthzMiddleware;
use charlymatloc\api\middlewares\CreerCompteMiddleware;
use charlymatloc\api\actions\AjouterAuPanierAction;
use charlymatloc\api\actions\VerifierDisponibiliteAction;
use charlymatloc\api\actions\AfficherHistoriqueAction;
use charlymatloc\api\middlewares\CreerReservationMiddleware;
use Slim\App;

return function (App $app):App {

    $app->get('/outillages', ListerOutillagesAction::class)->setName('lister_outils');

    $app->get('/outillages/{id}', AfficherOutillageAction::class)->setName('afficher_outil');

    $app->get('/categories', ListerCategoriesAction::class)->setName('lister_categories');

    $app->options('/users', function ($request, $response) {
        return $response;
    });
    $app->post('/users', CreerCompteAction::class)->add(CreerCompteMiddleware::class)->setName('creer_compte');

    $app->options('/login', function ($request, $response) {
        return $response;
    });
    $app->post('/login', ConnecterAction::class)->add(AuthnMiddleware::class)->setName('login');

    $app->get('/outils/{id}/disponibilite', VerifierDisponibiliteAction::class)->setName('verifier_disponibilite');

    $app->post('/panier/outils/{id}', AjouterAuPanierAction::class)->setName('ajouter_au_panier');

    $app->get('/historique', AfficherHistoriqueAction::class)
        ->add(AuthzMiddleware::class)
        ->setName('afficher_historique');

    $app->options('/reservations', function ($request, $response) {return $response;});

    $app->post('/reservations', CreerReservation::class)
        ->add(AuthzMiddleware::class)
        ->add(CreerReservationMiddleware::class)
        ->setName('creer_reservation');

    return $app;
};
