<?php

namespace RCatlin\Blog\Test\Integration;

use GuzzleHttp\Client;

abstract class AbstractIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp()
    {
        // TODO - Add Auth Headers once Authorization is setup for API.
        $this->client = new Client([
            'base_uri' => 'http://localhost:8000',
            'allow_redirects' => false,
        ]);
    }
}
