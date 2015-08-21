<?php

namespace RCatlin\Blog\Decorator;

use RCatlin\Blog\Controller\MainController;
use Refinery29\Piston\Decorator;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\Routes\Route;
use Refinery29\Piston\Router\Routes\RouteGroup;

/**
 * Class RouteDecorator
 * @package RCatlin\Blog\Decorator
 */
class RouteDecorator implements Decorator
{
    /**
     * @var Piston
     */
    private $app;

    /**
     * @param Piston $app
     */
    public function __construct(Piston $app)
    {
        $this->app = $app;
    }

    /**
     * @return Piston|RouteGroup
     */
    public function register()
    {
        $group = new RouteGroup([
            Route::get('/', MainController::class.'::index'),
        ]);

        $this->app->addRouteGroup($group);

        return $this->app;
    }
}
