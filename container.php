<?php

require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Dotenv\Dotenv;
use League\Container\Container;
use RCatlin\Blog\Entity;
use RCatlin\Blog\ServiceProvider;

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
$container->share(EntityManager::class, $entityManager);
$container->share(Dotenv::class, $dotenv);

$container->addServiceProvider(new ServiceProvider\ControllerServiceProvider());
$container->addServiceProvider(new ServiceProvider\RepositoryServiceProvider());
$container->addServiceProvider(new ServiceProvider\TransformerServiceProvider());
$container->addServiceProvider(new ServiceProvider\ValidatorServiceProvider());

return $container;
