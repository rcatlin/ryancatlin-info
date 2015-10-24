<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Transformer\TransformerContainer;

class SerializerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Serializer\FractalResourceFactory::class,
        Serializer\ScopeBuilder::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Serializer\FractalResourceFactory::class)
            ->withArgument(TransformerContainer::class)
        ;

        $container->share(Serializer\ScopeBuilder::class)
            ->withArgument(Manager::class)
            ->withArgument(Serializer\FractalResourceFactory::class)
        ;
    }
}
