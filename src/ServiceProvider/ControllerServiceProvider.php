<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer\Transformer;
use RCatlin\Blog\Validator;

class ControllerServiceProvider extends AbstractServiceProvider
{
    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Controller\Api\TagController::class)
            ->withArgument(Repository\TagRepository::class)
            ->withArgument(Transformer\Entity\TagTransformer::class)
            ->withArgument(Validator\Entity\TagValidator::class)
        ;
    }
}
