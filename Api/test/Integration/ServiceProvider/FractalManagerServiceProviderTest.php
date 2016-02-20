<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use League\Fractal\Manager;
use RCatlin\Api\ServiceProvider;

class FractalManagerServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\FractalManagerServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Manager::class, Manager::class],
        ];
    }
}
