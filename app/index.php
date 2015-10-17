<?php

/* @var Container */
$container = require __DIR__.'/../bootstrap.php';

use League\Container\Container;
use Refinery29\Piston\Piston;
use RCatlin\Blog\Middleware;

$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

$app = new Piston($container);

$app->addMiddleware(new Middleware\Route\Main());

$app->launch();
