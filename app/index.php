<?php

use League\Container\Container;
use Refinery29\Piston\Piston;

/* @var Container */
$container = require __DIR__.'/../bootstrap.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

/** @var Piston $app */
$app = $container->get(Piston::class);

$app->launch();
