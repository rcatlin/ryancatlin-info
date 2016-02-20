<?php

namespace RCatlin\Api\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;

class FractalManagerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Manager::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $this->getContainer()->share(Manager::class);
    }
}
