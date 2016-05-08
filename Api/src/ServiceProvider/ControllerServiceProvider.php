<?php

namespace RCatlin\Api\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Controller;
use RCatlin\Api\Repository;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Serializer;
use RCatlin\Api\Validator;

class ControllerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Controller\Api\ArticleCreateController::class,
        Controller\Api\ArticleCountController::class,
        Controller\Api\ArticleDeleteController::class,
        Controller\Api\ArticleGetController::class,
        Controller\Api\ArticleUpdateController::class,
        Controller\Api\StatusController::class,
        Controller\Api\TagCreateController::class,
        Controller\Api\TagDeleteController::class,
        Controller\Api\TagGetController::class,
        Controller\Api\TagUpdateController::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Controller\Api\ArticleCreateController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(ReverseTransformer\Entity\ArticleReverseTransformer::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Validator\Entity\ArticleValidator::class)
        ;

        $container->share(Controller\Api\ArticleCountController::class)
            ->withArgument(Repository\ArticleRepository::class)
            ->withArgument(Serializer\ScopeBuilder::class)
        ;

        $container->share(Controller\Api\ArticleDeleteController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Repository\ArticleRepository::class)
        ;

        $container->share(Controller\Api\ArticleGetController::class)
            ->withArgument(Repository\ArticleRepository::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Repository\TagRepository::class)
        ;

        $container->share(Controller\Api\ArticleUpdateController::class)
            ->withArgument(ReverseTransformer\Entity\ArticleReverseTransformer::class)
            ->withArgument(Validator\Entity\ArticleValidator::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Serializer\ScopeBuilder::class)
        ;

        $container->share(Controller\Api\StatusController::class);

        $container->share(Controller\Api\TagCreateController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(ReverseTransformer\Entity\TagReverseTransformer::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Validator\Entity\TagValidator::class)
        ;

        $container->share(Controller\Api\TagDeleteController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Repository\TagRepository::class)
        ;

        $container->share(Controller\Api\TagGetController::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(Repository\TagRepository::class)
        ;

        $container->share(Controller\Api\TagUpdateController::class)
            ->withArgument(EntityManager::class)
            ->withArgument(Serializer\ScopeBuilder::class)
            ->withArgument(ReverseTransformer\Entity\TagReverseTransformer::class)
            ->withArgument(Validator\Entity\TagValidator::class)
        ;
    }
}
