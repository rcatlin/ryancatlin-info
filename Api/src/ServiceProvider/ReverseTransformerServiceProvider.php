<?php

namespace RCatlin\Api\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Repository;
use RCatlin\Api\ReverseTransformer;

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
            ->withArgument(EntityManager::class)
            ->withArgument(Repository\ArticleRepository::class)
            ->withArgument(ReverseTransformer\Entity\TagReverseTransformer::class)
        ;

        $container->share(ReverseTransformer\Entity\TagReverseTransformer::class)
            ->withArgument(Repository\TagRepository::class)
        ;
    }
}
