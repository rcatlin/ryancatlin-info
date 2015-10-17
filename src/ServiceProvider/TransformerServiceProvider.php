<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Serializer\Transformer;

class TransformerServiceProvider extends AbstractServiceProvider
{
    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Transformer\DateTimeTransformer::class);

        $container->share(Transformer\Entity\ArticleTransformer::class)
            ->withArgument(Transformer\Entity\TagTransformer::class)
            ->withArgument(Transformer\DateTimeTransformer::class)
        ;

        $container->share(Transformer\Entity\TagTransformer::class);
    }
}
