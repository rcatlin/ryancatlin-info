<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use League\Container\Container;

// Create our container
$container = new Container();

// Get our environment
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$conn = \Doctrine\DBAL\DriverManager::getConnection([
    'dbname' => getenv('DATABASE_NAME'),
    'user' => getenv('DATABASE_USER'),
    'password' => getenv('DATABASE_PASSWORD'),
    'host' => getenv('DATABASE_HOST'),
    'driver' => getenv('DATABASE_DRIVER'),
]);

$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/src/Entity'], getenv('IS_PROD'), null, null, false);

$entityManager = EntityManager::create($conn, $config);

// Add Services to Container
$container->add(EntityManager::class, $entityManager);
$container->add(Dotenv::class, $dotenv);

return $container;
