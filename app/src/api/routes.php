<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutilAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\ListerOutilsAction;
use charlymatloc\api\middlewares\AuthnMiddleware;
use charlymatloc\api\middlewares\AuthzMiddleware;
use charlymatloc\api\middlewares\CreerCompteMiddleware;
use charlymatloc\api\actions\AjouterAuPanierAction;
use charlymatloc\api\actions\VerifierDisponibiliteAction;
use Slim\App;
use charlymatloc\api\actions\AfficherHistoriqueAction;

return function (App $app):App {

    $app->get('/outils', ListerOutilsAction::class)->setName('lister_outils');

    $app->get('/outils/{id}', AfficherOutilAction::class)->setName('afficher_outil');

    $app->post('/users', CreerCompteAction::class)->add(CreerCompteMiddleware::class)->setName('creer_compte');

    $app->post('/login', ConnecterAction::class)->add(AuthnMiddleware::class)->setName('login');

    $app->get('/outils/{id}/disponibilite', VerifierDisponibiliteAction::class)->setName('verifier_disponibilite');

    $app->post('/panier/outils/{id}', AjouterAuPanierAction::class)->setName('ajouter_au_panier');

    $app->get('/historique', AfficherHistoriqueAction::class)
        ->add(AuthzMiddleware::class)
        ->setName('historique');




    return $app;
};
