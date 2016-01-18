<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

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
            new ServiceProvider\ReverseTransformerServiceProvider(),
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
                Controller\Api\ArticleCreateController::class,
                Controller\Api\ArticleCreateController::class,
            ],
            [
                Controller\Api\ArticleDeleteController::class,
                Controller\Api\ArticleDeleteController::class,
            ],
            [
                Controller\Api\ArticleGetController::class,
                Controller\Api\ArticleGetController::class,
            ],
            [
                Controller\Api\ArticleUpdateController::class,
                Controller\Api\ArticleUpdateController::class,
            ],
            [
                Controller\Api\StatusController::class,
                Controller\Api\StatusController::class,
            ],
            [
                Controller\Api\TagCreateController::class,
                Controller\Api\TagCreateController::class,
            ],
            [
                Controller\Api\TagDeleteController::class,
                Controller\Api\TagDeleteController::class,
            ],
            [
                Controller\Api\TagGetController::class,
                Controller\Api\TagGetController::class,
            ],
        ];
    }
}
