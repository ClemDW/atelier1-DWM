<?php
declare(strict_types=1);

use charlymatloc\api\actions\AfficherOutillageAction;
use charlymatloc\api\actions\ConnecterAction;
use charlymatloc\api\actions\CreerCompteAction;
use charlymatloc\api\actions\ListerOutillagesAction;
use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\api\actions\AjouterAuPanierAction;
use charlymatloc\api\actions\VerifierDisponibiliteAction;
use charlymatloc\api\actions\AfficherHistoriqueAction;
use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;

use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;

return [
    ListerOutillagesAction::class => function($container){
        return new ListerOutillagesAction($container->get(OutilsServiceInterface::class));
    },

    AfficherOutillageAction::class => function($container){
        return new AfficherOutillageAction($container->get(OutilsServiceInterface::class));
    },


    CreerCompteAction::class => function($container){
        return new CreerCompteAction($container->get(AuthServiceInterface::class));
    },

    ConnecterAction::class => function($container) {
        return new ConnecterAction($container->get(AuthServiceInterface::class));
    },

    VerifierDisponibiliteAction::class => function($container){
        return new VerifierDisponibiliteAction($container->get(OutilsServiceInterface::class));
    },

    AfficherHistoriqueAction::class => function($container){
        return new AfficherHistoriqueAction($container->get(ReservServiceInterface::class));
    },


    AjouterAuPanierAction::class => function($container){
        return new AjouterAuPanierAction($container->get(OutilsServiceInterface::class));
    }
];
