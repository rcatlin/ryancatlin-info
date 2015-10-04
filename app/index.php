<?php

/* @var Container */
$container = require __DIR__ . '/../bootstrap.php';

use League\Container\Container;
use Refinery29\Piston\Piston;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$app = new Piston($container);

$app->addDecorator(new \RCatlin\Blog\Decorator\RouteDecorator($app));

$app->launch();
