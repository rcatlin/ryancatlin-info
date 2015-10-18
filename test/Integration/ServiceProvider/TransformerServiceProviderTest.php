<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer\Transformer;
use RCatlin\Blog\ServiceProvider;

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
