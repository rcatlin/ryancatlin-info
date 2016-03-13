<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use RCatlin\Api\Entity;
use RCatlin\Api\ServiceProvider;
use RCatlin\Api\Transformer;

class TransformerServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\TransformerServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [\DateTime::class, Transformer\DateTimeTransformer::class],
            [Entity\Article::class, Transformer\Entity\ArticleTransformer::class],
            [Entity\Tag::class, Transformer\Entity\TagTransformer::class],
            [Transformer\DateTimeTransformer::class, Transformer\DateTimeTransformer::class],
            [Transformer\Entity\ArticleTransformer::class, Transformer\Entity\ArticleTransformer::class],
            [Transformer\Entity\TagTransformer::class, Transformer\Entity\TagTransformer::class],
        ];
    }
}
