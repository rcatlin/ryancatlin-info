<?php

namespace RCatlin\Api\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Api\Entity;
use RCatlin\Api\Test\Integration\AbstractIntegrationTest;
use Teapot\StatusCode;

class ArticleCountControllerTest extends AbstractIntegrationTest
{
    public function testGetActiveCount()
    {
        FactoryMuffin::create(Entity\Article::class, [
            'active' => false,
        ]);

        FactoryMuffin::create(Entity\Article::class, [
            'active' => false,
        ]);

        FactoryMuffin::create(Entity\Article::class, [
            'active' => true,
        ]);

        FactoryMuffin::create(Entity\Article::class, [
            'active' => true
        ]);

        FactoryMuffin::create(Entity\Article::class, [
            'active' => true
        ]);

        $response = $this->client->get(
            sprintf('/api/articles/count')
        );

        $this->assertSame(StatusCode::OK, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(3, $content['result']['count']);
    }

    public function testGetActiveCountIsEmpty()
    {
        $response = $this->client->get(
            sprintf('/api/articles/count')
        );

        $this->assertSame(StatusCode::OK, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);

        $this->assertSame(0, $content['result']['count']);
    }

    public function testNonActiveCountIsABadRequest()
    {
        $response = $this->client->get(
            sprintf('/api/articles/count?active=0')
        );

        $this->assertSame(StatusCode::BAD_REQUEST, $response->getStatusCode());
    }
}
