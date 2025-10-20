<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'pdo.auth' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['auth'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['pass']);
    },

    'pdo.outils' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['outils'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['pass']);
    },

    'pdo.reservations' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['reservations'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['pass']);
    }
];
