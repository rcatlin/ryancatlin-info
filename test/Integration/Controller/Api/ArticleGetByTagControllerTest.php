<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\LoadsFactoryMuffinFactories;
use RCatlin\Blog\Test\ReadsResponseContent;

class ArticleGetByTagControllerTest extends AbstractIntegrationTest
{
    use HasFaker;
    use LoadsFactoryMuffinFactories;
    use ReadsResponseContent;

    public function testGetByTags()
    {
        $faker = $this->getFaker();

        $tagName = $faker->word;

        /** @var Entity\Article $article */
        $article = FactoryMuffin::create(Entity\Article::class, [
            'tag' => $tagName,
            'active' => true,
        ]);

        $tag = $article->getTags()->first();

        $response = $this->client->get(
            sprintf('/api/articles/tag/%s', $tag->getName())
        );

        $this->assertSame(200, $response->getStatusCode());

        $content = json_decode($this->readResponse($response), true);

        $data = $content['result']['data'];

        $this->assertTrue(is_array($data));
        $this->assertSame(1, count($data));

        $articleData = $data[0];

        $this->assertSame($article->getId(), $articleData['id']);
        $this->assertSame(1, count($articleData['tags']));

        $tagData = $articleData['tags'][0];

        $this->assertSame($tag->getId(), $tagData['id']);
    }
}
