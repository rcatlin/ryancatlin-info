<?php

namespace RCatlin\Api\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Entity;
use RCatlin\Api\Transformer;

class TransformerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        \DateTime::class,
        Entity\Article::class,
        Entity\Tag::class,
        Transformer\DateTimeTransformer::class,
        Transformer\Entity\ArticleTransformer::class,
        Transformer\Entity\TagTransformer::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Transformer\DateTimeTransformer::class);
        $container->share(\DateTime::class, function () {
            return $this->getContainer()->get(Transformer\DateTimeTransformer::class);
        });

        $container->share(Transformer\Entity\ArticleTransformer::class)
            ->withArgument(Transformer\Entity\TagTransformer::class)
            ->withArgument(Transformer\DateTimeTransformer::class)
        ;
        $container->share(Entity\Article::class, function () {
            return $this->getContainer()->get(Transformer\Entity\ArticleTransformer::class);
        });

        $container->share(Transformer\Entity\TagTransformer::class);
        $container->share(Entity\Tag::class, function () {
            return $this->getContainer()->get(Transformer\Entity\TagTransformer::class);
        });
    }
}
