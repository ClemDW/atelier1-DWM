<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutilAction;
use charlymatloc\api\actions\AjouterAuPanierAction;
use charlymatloc\api\actions\ListerOutilsAction;
use charlymatloc\api\actions\VerifierDisponibiliteAction;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;

return [
    ListerOutilsAction::class => function($container){
        return new ListerOutilsAction($container->get(OutilsServiceInterface::class));
    },

    AfficherOutilAction::class => function($container){
        return new AfficherOutilAction($container->get(OutilsServiceInterface::class));
    },

    VerifierDisponibiliteAction::class => function($container){
        return new VerifierDisponibiliteAction($container->get(OutilsServiceInterface::class));
    },

    AjouterAuPanierAction::class => function($container){
        return new AjouterAuPanierAction($container->get(OutilsServiceInterface::class));
    }
];
