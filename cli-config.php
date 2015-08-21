<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use League\Container\Container;
use Symfony\Component\Console\Helper\HelperSet;

/* @var Container */
$container = require 'container.php';

/* @var EntityManager */
$em = $container->get(EntityManager::class);

return new HelperSet([
    'db' => new ConnectionHelper($em->getConnection()),
    'em' => new EntityManagerHelper($em),
]);

