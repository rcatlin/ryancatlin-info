<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\Serializer;
use RCatlin\Blog\ServiceProvider\FractalManagerServiceProvider;
use RCatlin\Blog\ServiceProvider\SerializerServiceProvider;
use RCatlin\Blog\ServiceProvider\TransformerContainerServiceProvider;

class SerializerServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new FractalManagerServiceProvider(),
            new SerializerServiceProvider(),
            new TransformerContainerServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Serializer\FractalResourceFactory::class, Serializer\FractalResourceFactory::class],
            [Serializer\ScopeBuilder::class, Serializer\ScopeBuilder::class],
        ];
    }
}
