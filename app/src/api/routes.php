<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutilAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\ListerOutilsAction;
use charlymatloc\api\middlewares\ConnecterMiddleware;
use charlymatloc\api\middlewares\CreerCompteMiddleware;
use Slim\App;

return function (App $app):App {

    $app->get('/outils', ListerOutilsAction::class)->setName('lister_outils');

    $app->get('/outils/{id}', AfficherOutilAction::class)->setName('afficher_outil');

    $app->post('/users', CreerCompteAction::class)->add(CreerCompteMiddleware::class)->setName('creer_compte');

    $app->post('/login', ConnecterAction::class)->add(ConnecterMiddleware::class)->setName('login');

    return $app;
};