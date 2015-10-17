<?php

namespace RCatlin\Blog\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;

class RepositoryServiceProvider extends AbstractServiceProvider
{
    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Repository\TagRepository::class, function () {
            /** @var EntityManager $em */
            $em = $this->getContainer()->get(EntityManager::class);

            return $em->getRepository(Entity\Tag::class);
        });
    }
}
