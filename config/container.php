<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use League\Container\Container;
use RCatlin\Blog\ServiceProvider;

// Create our container
$container = new Container();

// Get our environment
$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Add Services to Container
$container->share(Dotenv::class, $dotenv);

$container->addServiceProvider(new ServiceProvider\PistonServiceProvider());
$container->addServiceProvider(new ServiceProvider\EntityManagerServiceProvider(
    getenv('DATABASE_NAME'),
    getenv('DATABASE_USER'),
    getenv('DATABASE_PASSWORD'),
    getenv('DATABASE_HOST'),
    getenv('DATABASE_DRIVER'),
    getenv('ENTITY_DIR'),
    getenv('IS_PROD')
));
$container->addServiceProvider(new ServiceProvider\ControllerServiceProvider());
$container->addServiceProvider(new ServiceProvider\FractalManagerServiceProvider());
$container->addServiceProvider(new ServiceProvider\RepositoryServiceProvider());
$container->addServiceProvider(new ServiceProvider\ReverseTransformerServiceProvider());
$container->addServiceProvider(new ServiceProvider\SerializerServiceProvider());
$container->addServiceProvider(new ServiceProvider\TransformerContainerServiceProvider());
$container->addServiceProvider(new ServiceProvider\ValidatorServiceProvider());

return $container;
