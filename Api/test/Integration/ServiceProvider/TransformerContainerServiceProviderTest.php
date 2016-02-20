<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use RCatlin\Api\ServiceProvider;
use RCatlin\Api\Transformer;

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
