<?php

namespace RCatlin\Blog\Test\Integration;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use League\Container\Container;
use RCatlin\Blog\Entity;

abstract class AbstractIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Container
     */
    protected static $container;

    /**
     * @var EntityManager
     */
    protected static $entityManager;

    public function setUp()
    {
        // TODO - Add Auth Headers once Authorization is setup for API.
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000',
            'allow_redirects' => false,
            'http_errors' => false,
        ]);
    }

    public function tearDown()
    {
        $entityClasses = [
            Entity\Tag::class,
            Entity\Article::class,
            Entity\User::class,
        ];

        foreach ($entityClasses as $entityClass) {
            $query = self::$entityManager->createQuery(
                sprintf('DELETE FROM %s', $entityClass)
            );
            $query->execute();
        }
    }

    public static function setUpBeforeClass()
    {
        self::createContainer();

        self::$entityManager = self::$container->get(EntityManager::class);
    }

    public static function tearDownAfterClass()
    {
        self::$entityManager = null;
        self::$container = null;
    }

    public static function createContainer()
    {
        $container = require __DIR__ . '/../../config/container.php';

        self::$container = $container;
    }
}
