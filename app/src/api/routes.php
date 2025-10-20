<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutilAction;
use charlymatloc\api\actions\ListerOutilsAction;
use Slim\App;

return function (App $app):App {

    $app->get('/outils', ListerOutilsAction::class)->setName('lister_outils');

    $app->get('/outils/{id}', AfficherOutilAction::class)->setName('afficher_outil');

    return $app;
};