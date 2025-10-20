<?php
declare(strict_types=1);

use charlymatloc\api\actions\ListerOutilsAction;
use Slim\App;

return function (App $app):App {

    $app->get('/outils', ListerOutilsAction::class)->setName('liste_outils');

    return $app;
};