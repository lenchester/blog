<?php

return [
    'migrations_paths' => [
        'Migrations' => __DIR__ . '/../migrations', // Namespace => directory mapping
    ],
    'connection' => [
        'driver'   => 'pdo_mysql',  // Update as per your DB
        'host'     => $_ENV['DB_HOST'],
        'dbname'   => $_ENV['DB_NAME'],
        'user'     => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset'  => 'utf8mb4',
    ],
];