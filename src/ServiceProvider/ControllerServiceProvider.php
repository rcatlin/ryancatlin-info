<?php

namespace RCatlin\Blog\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;

class ControllerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Controller\Api\ArticleController::class,
        Controller\Api\StatusController::class,
        Controller\Api\TagController::class,
        Controller\MainController::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Controller\Api\ArticleController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Repository\ArticleRepository::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Validator\Entity\ArticleValidator::class)
        ;

        $container->share(Controller\Api\StatusController::class);

        $container->share(Controller\Api\TagController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Repository\TagRepository::class)
            ->withArgument(Validator\Entity\TagValidator::class)
        ;

        $container->share(Controller\MainController::class);
    }
}
