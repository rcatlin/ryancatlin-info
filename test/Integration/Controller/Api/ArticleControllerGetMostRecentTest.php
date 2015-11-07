<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\CreatesGuzzleStream;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\LoadsFactoryMuffinFactories;
use RCatlin\Blog\Test\ReadsResponseContent;

class ArticleControllerGetMostRecentTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use LoadsFactoryMuffinFactories;
    use ReadsResponseContent;

    public function testGetMostRecent()
    {
        /** @var Entity\Article $article0 */
        $article0 = FactoryMuffin::create(Entity\Article::class, [
            'active' => true,
            'createdAt' => 'dateTimeBetween|-3 days;-2 days',
        ]);

        /** @var Entity\Article $article1 */
        $article1 = FactoryMuffin::create(Entity\Article::class, [
            'active' => true,
            'createdAt' => 'dateTimeBetween|-1 day;now',
        ]);

        $response = $this->client->get('/api/articles/mostrecent');

        $this->assertSame(200, $response->getStatusCode());

        $content = json_decode($this->readResponse($response), true);

        $this->assertSame($article1->getId(), $content['result']['data']['id']);
    }
}
