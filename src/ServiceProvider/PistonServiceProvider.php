<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Middleware;
use Refinery29\Piston\Piston;

class PistonServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Piston::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Piston::class, function () use ($container) {
            $app = new Piston($container);

            $app->addMiddleware(new Middleware\Route\Api())
                ->addMiddleware(new Middleware\Route\Main())
            ;

            return $app;
        });
    }
}
