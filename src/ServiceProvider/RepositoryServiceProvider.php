<?php

namespace RCatlin\Blog\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;

class RepositoryServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Repository\TagRepository::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Repository\TagRepository::class, function () use ($container) {
            /** @var EntityManager $em */
            $em = $container->get(EntityManager::class);

            return $em->getRepository(Entity\Tag::class);
        });
    }
}
