<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use RCatlin\Api\ServiceProvider;
use RCatlin\Api\Test\HasFaker;
use Refinery29\Piston\Piston;

class PistonServiceProviderTest extends AbstractServiceProviderTest
{
    use HasFaker;

    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        $faker = $this->getFaker();

        return [
            new ServiceProvider\PistonServiceProvider($faker->word, $faker->word),
        ];
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
