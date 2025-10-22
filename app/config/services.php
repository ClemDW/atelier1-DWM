<?php
declare(strict_types=1);

use charlymatloc\core\application\ports\api\serviceinterfaces\AuthServiceInterface;
use charlymatloc\core\application\ports\api\serviceinterfaces\OutilsServiceInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\OutilsRepositoryInterface;
use charlymatloc\core\application\usecases\AuthService;
use charlymatloc\core\application\ports\spi\repositoryInterfaces\ReservRepositoryInterface;
use charlymatloc\core\application\usecases\OutilsService;
use charlymatloc\infra\repositories\AuthRepository;
use charlymatloc\infra\repositories\OutilsRepository;
use charlymatloc\infra\repositories\ReservRepository;
use charlymatloc\core\application\usecases\ReservService;
use charlymatloc\core\application\ports\api\serviceinterfaces\ReservServiceInterface;
use Psr\Container\ContainerInterface;

return [

    'pdo.auth' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['auth'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['password']);
    },

    'pdo.outils' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['outils'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['password']);
    },

    'pdo.reservations' => function (ContainerInterface $container) {
        $db = $container->get('settings')['db']['reservations'];
        return new PDO(
            "{$db['driver']}:host={$db['host']};dbname={$db['dbname']}",
            $db['user'],
            $db['password']);
    },

    OutilsRepositoryInterface::class => function (ContainerInterface $container) {
        return new OutilsRepository($container->get('pdo.outils'));
    },

    ReservRepositoryInterface::class => function (ContainerInterface $container) {
        return new ReservRepository($container->get('pdo.reservations'));
    },

    ReservServiceInterface::class => function (ContainerInterface $container) {
        return new ReservService($container->get(ReservRepositoryInterface::class));
    },

    OutilsServiceInterface::class => function (ContainerInterface $container) {
        return new OutilsService($container->get(OutilsRepositoryInterface::class), $container->get(ReservRepositoryInterface::class));
    },

    AuthRepositoryInterface::class => function (ContainerInterface $container) {
        return new AuthRepository($container->get('pdo.auth'));
    },

    AuthServiceInterface::class => function (ContainerInterface $container) {
        return new AuthService($container->get(AuthRepositoryInterface::class));
    }
];
