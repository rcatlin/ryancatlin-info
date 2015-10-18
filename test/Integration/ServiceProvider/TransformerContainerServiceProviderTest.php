<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\Serializer;
use RCatlin\Blog\ServiceProvider;

class TransformerContainerServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\TransformerContainerServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Serializer\TransformerContainer::class, Serializer\TransformerContainer::class],
        ];
    }
}
