<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\Container;
use RCatlin\Blog\ServiceProvider;

class EntityManagerServiceProviderTest extends AbstractServiceProviderTest
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
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [EntityManager::class, EntityManager::class]
        ];
    }
}
