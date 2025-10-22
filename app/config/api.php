<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutilAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\ListerOutilsAction;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;

return [
    ListerOutilsAction::class => function($container){
        return new ListerOutilsAction($container->get(OutilsServiceInterface::class));
    },

    AfficherOutilAction::class => function($container){
        return new AfficherOutilAction($container->get(OutilsServiceInterface::class));
    },

    CreerCompteAction::class => function($container){
        return new CreerCompteAction($container->get(AuthServiceInterface::class));
    },

    ConnecterAction::class => function($container){
        return new ConnecterAction($container->get(AuthServiceInterface::class));
    }
];