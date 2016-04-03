<?php

namespace RCatlin\Api\Test\Integration;

use GuzzleHttp\Client;
use RCatlin\Api\Entity;
use RCatlin\Api\Test\AbstractRequiresContainerTest;

abstract class AbstractIntegrationTest extends AbstractRequiresContainerTest
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
}
