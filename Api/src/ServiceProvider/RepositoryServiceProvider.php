<?php

namespace RCatlin\Api\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Entity;
use RCatlin\Api\Repository;

class RepositoryServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Repository\ArticleRepository::class,
        Repository\TagRepository::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Repository\ArticleRepository::class, function () use ($container) {
            /** @var EntityManager $em */
            $em = $container->get(EntityManager::class);

            return $em->getRepository(Entity\Article::class);
        });

        $container->share(Repository\TagRepository::class, function () use ($container) {
            /** @var EntityManager $em */
            $em = $container->get(EntityManager::class);

            return $em->getRepository(Entity\Tag::class);
        });
    }
}
