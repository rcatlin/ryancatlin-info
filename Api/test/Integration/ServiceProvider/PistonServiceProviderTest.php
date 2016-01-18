<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\ServiceProvider;
use Refinery29\Piston\Piston;

class PistonServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [new ServiceProvider\PistonServiceProvider()];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Piston::class, Piston::class],
        ];
    }
}
