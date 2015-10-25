<?php

namespace RCatlin\Blog\Test\Integration;

use GuzzleHttp\Client;
use League\Container\Container;

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

    public function setUp()
    {
        // TODO - Add Auth Headers once Authorization is setup for API.
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000',
            'allow_redirects' => false,
            'http_errors' => false,
        ]);
    }

    public static function setUpBeforeClass()
    {
        self::createContainer();
    }

    public static function tearDownAfterClass()
    {
        self::$container = null;
    }

    public static function createContainer()
    {
        $container = require __DIR__ . '/../../config/container.php';

        self::$container = $container;
    }
}
