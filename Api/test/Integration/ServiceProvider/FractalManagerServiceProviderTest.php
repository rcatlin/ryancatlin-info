<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use League\Fractal\Manager;
use RCatlin\Blog\ServiceProvider;

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
