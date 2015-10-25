<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;

class ReverseTransformerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ReverseTransformer\Entity\ArticleReverseTransformer::class,
        ReverseTransformer\Entity\TagReverseTransformer::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(ReverseTransformer\Entity\ArticleReverseTransformer::class)
            ->withArgument(Repository\ArticleRepository::class)
            ->withArgument(ReverseTransformer\Entity\TagReverseTransformer::class)
        ;

        $container->share(ReverseTransformer\Entity\TagReverseTransformer::class)
            ->withArgument(Repository\TagRepository::class)
        ;
    }
}
