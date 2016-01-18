<?php

namespace RCatlin\Blog\Test;

use Doctrine\ORM\EntityManager;
use League\Container\Container;

abstract class AbstractRequiresContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected static $container;

    /**
     * @var EntityManager
     */
    protected static $entityManager;

    /**
     * Create Container and retrieve EntityManager from Container
     */
    public static function setUpBeforeClass()
    {
        self::createContainer();

        self::$entityManager = self::$container->get(EntityManager::class);
    }

    /**
     * Destroy EntityManager and Container references
     */
    public static function tearDownAfterClass()
    {
        self::$entityManager = null;
        self::$container = null;
    }

    /**
     * Create the Container
     */
    public static function createContainer()
    {
        $container = require __DIR__ . '/../config/container.php';

        self::$container = $container;
    }
}
