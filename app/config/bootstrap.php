<?php

use charlymatloc\api\middlewares\CorsMiddleware;
use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require __DIR__ . '/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->add(new CorsMiddleware());
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$app = (require __DIR__ . '/../src/api/routes.php')($app);

return $app;