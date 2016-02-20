<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use RCatlin\Api\Serializer;
use RCatlin\Api\ServiceProvider\FractalManagerServiceProvider;
use RCatlin\Api\ServiceProvider\SerializerServiceProvider;
use RCatlin\Api\ServiceProvider\TransformerContainerServiceProvider;

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
