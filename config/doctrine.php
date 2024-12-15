<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;

require_once __DIR__ . '/../vendor/autoload.php';

// Database connection parameters
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'host'     => '127.0.0.1',
    'port'     => 5432,
    'dbname'   => 'postgres',
    'user'     => 'maratpak',
    'password' => 'root',
];

// Paths to entity classes
$entityPaths = [__DIR__ . '/../src/Entity'];

// Set up configuration
$config = new Configuration();
$config->setMetadataDriverImpl(new AttributeDriver($entityPaths));
$config->setProxyDir(__DIR__ . '/../var/proxies');
$config->setProxyNamespace('Proxies');
$config->setAutoGenerateProxyClasses(true); // Set to false for production

// Create the EntityManager
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;
