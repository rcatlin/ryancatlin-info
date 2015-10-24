<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\ServiceProvider;
use RCatlin\Blog\Transformer;

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
            [Transformer\TransformerContainer::class, Transformer\TransformerContainer::class],
        ];
    }
}
