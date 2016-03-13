<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use RCatlin\Api\Repository;
use RCatlin\Api\ServiceProvider;

class RepositoryServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\EntityManagerServiceProvider(
                getenv('DATABASE_NAME'),
                getenv('DATABASE_USER'),
                getenv('DATABASE_PASSWORD'),
                getenv('DATABASE_HOST'),
                getenv('DATABASE_DRIVER'),
                getenv('ENTITY_DIR'),
                getenv('IS_PROD')
            ),
            new ServiceProvider\RepositoryServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Repository\TagRepository::class, Repository\TagRepository::class],
            [Repository\ArticleRepository::class, Repository\ArticleRepository::class],
        ];
    }
}
