<?php

require_once __DIR__ . '/bootstrap.php';

use Refinery29\Piston\Piston;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$app = new Piston();

$app->addDecorator(new \RCatlin\Blog\Decorator\RouteDecorator($app));

$app->launch();
