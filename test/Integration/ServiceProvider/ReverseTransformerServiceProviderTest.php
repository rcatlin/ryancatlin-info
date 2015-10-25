<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\ServiceProvider;

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
            new ServiceProvider\ReverseTransformerServiceProvider(),
            new ServiceProvider\RepositoryServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [
                ReverseTransformer\Entity\ArticleReverseTransformer::class,
                ReverseTransformer\Entity\ArticleReverseTransformer::class,
            ],
            [
                ReverseTransformer\Entity\TagReverseTransformer::class,
                ReverseTransformer\Entity\TagReverseTransformer::class,
            ],
        ];
    }
}
