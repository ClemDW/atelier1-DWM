<?php
declare(strict_types=1);

use charlymatloc\api\actions\ListerOutilsAction;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;

return [
    ListerOutilsAction::class => function($container){
        return new ListerOutilsAction($container->get(OutilsServiceInterface::class));
    }
];