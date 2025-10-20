<?php
declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/settings.php');
$containerBuilder->addDefinitions(__DIR__ . '/services.php');
$containerBuilder->addDefinitions(__DIR__ . '/api.php');

try {
    return $containerBuilder->build();
} catch (Exception $e) {
    echo "Error building container: " . $e->getMessage();
    exit(1);
}