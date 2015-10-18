<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use Assert\Assertion;
use League\Container\Container;
use RCatlin\Blog\Controller;
use RCatlin\Blog\ServiceProvider;

class ControllerServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\ControllerServiceProvider(),
            new ServiceProvider\EntityManagerServiceProvider(
                getenv('DATABASE_NAME'),
                getenv('DATABASE_USER'),
                getenv('DATABASE_PASSWORD'),
                getenv('DATABASE_HOST'),
                getenv('DATABASE_DRIVER'),
                getenv('ENTITY_DIR'),
                getenv('IS_PROD')
            ),
            new ServiceProvider\FractalManagerServiceProvider(),
            new ServiceProvider\RepositoryServiceProvider(),
            new ServiceProvider\SerializerServiceProvider(),
            new ServiceProvider\TransformerContainerServiceProvider(),
            new ServiceProvider\ValidatorServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [
                Controller\Api\StatusController::class,
                Controller\Api\StatusController::class,
            ],
            [
                Controller\Api\TagController::class,
                Controller\Api\TagController::class,
            ],
            [
                Controller\MainController::class,
                Controller\MainController::class,
            ],
        ];
    }
}
