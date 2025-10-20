<?php
declare(strict_types=1);

return [
    'settings' => [
        'db' => [
            'auth' =>[
                'driver' => $_ENV['auth.driver'],
                'host' => $_ENV['auth.host'],
                'dbname' => $_ENV['auth.database'],
                'user' => $_ENV['auth.username'],
                'password' => $_ENV['auth.password'],
            ],
            'outils' =>[
                'driver' => $_ENV['outils.driver'],
                'host' => $_ENV['outils.host'],
                'dbname' => $_ENV['outils.database'],
                'user' => $_ENV['outils.username'],
                'password' => $_ENV['outils.password'],
            ],
            'reservations' =>[
                'driver' => $_ENV['reservations.driver'],
                'host' => $_ENV['reservations.host'],
                'dbname' => $_ENV['reservations.database'],
                'user' => $_ENV['reservations.username'],
                'password' => $_ENV['reservations.password'],
            ]
        ]
    ]
];