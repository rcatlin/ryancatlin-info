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
        Repository\UserRepository::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $this->container->share(Repository\ArticleRepository::class, function () {
            /** @var EntityManager $em */
            $em = $this->container->get(EntityManager::class);

            return $em->getRepository(Entity\Article::class);
        });

        $this->container->share(Repository\TagRepository::class, function () {
            /** @var EntityManager $em */
            $em = $this->container->get(EntityManager::class);

            return $em->getRepository(Entity\Tag::class);
        });

        $this->container->share(Repository\UserRepository::class, function () {
            /** @var EntityManager $em */
            $em = $this->container->get(EntityManager::class);

            return $em->getRepository(Entity\User::class);
        });
    }
}
