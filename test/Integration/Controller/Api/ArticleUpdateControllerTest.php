<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\CreatesGuzzleStream;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\LoadsFactoryMuffinFactories;
use RCatlin\Blog\Test\ReadsResponseContent;

class ArticleUpdateControllerTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use LoadsFactoryMuffinFactories;
    use ReadsResponseContent;

    public function testPartialUpdate()
    {
        $faker = $this->getFaker();

        $active = $faker->boolean();

        // Create Article And Tag
        /** @var Entity\Article $article */
        $article = FactoryMuffin::create(Entity\Article::class, [
            'active' => $active,
            'tagCount' => '1',
        ]);

        $articleId = $article->getId();

        /** @var Entity\Tag $tag */
        $tag = $article->getTags()->first();

        $tagId = $tag->getId();

        $newSlug = $faker->word;
        $newTitle = $faker->sentence;
        $newContent = $faker->sentence;
        $newActive = !$active;
        $newTagName = $faker->word;
        $anotherTagName = $faker->word;

        // Update, include a New Tag to be Created
        $response = $this->client->request(
            'PATCH',
            sprintf('/api/articles/%s', $articleId),
            [
                'body' => $this->createStreamFromArray(
                    [
                        'slug' => $newSlug,
                        'title' => $newTitle,
                        'content' => $newContent,
                        'active' => $newActive,
                        'tags' => [
                            [
                                'id' => $tagId,
                                'name' => $newTagName,
                            ],
                            [
                                'name' => $anotherTagName,
                            ],
                        ],
                    ]
                ),
            ]
        );

        $this->assertEquals(202, $response->getStatusCode());

        $content = json_decode($this->readResponse($response), true);

        $data = $content['result']['data'];

        $this->assertEquals($data['id'], $articleId);
        $this->assertEquals($data['slug'], $newSlug);
        $this->assertEquals($data['title'], $newTitle);
        $this->assertEquals($data['content'], $newContent);
        $this->assertEquals($data['active'], $newActive);
        $this->assertEquals(2, count($data['tags']));

        foreach ($data['tags'] as $tagData) {
            if ($tagData['id'] == $tagId) {
                $this->assertEquals($newTagName, $tagData['name']);
                continue;
            }

            $this->assertNotEquals($tagId, $tagData['id']);
            $this->assertEquals($anotherTagName, $tagData['name']);
        }

        // Update a Single Field
        $newerTitle = $faker->sentence;
        $newerTagName = $faker->word;

        $response = $this->client->request(
            'PATCH',
            sprintf('/api/articles/%s', $articleId),
            [
                'body' => $this->createStreamFromArray(
                    [
                        'title' => $newerTitle,
                        'tags' => [
                            ['name' => $newerTagName],
                        ],
                    ]
                ),
            ]
        );

        $this->assertEquals(202, $response->getStatusCode());

        // Verify Article
        $response = $this->client->request(
            'GET',
            sprintf('/api/articles/%s', $articleId)
        );

        $content = json_decode($this->readResponse($response), true);

        $data = $content['result']['data'];

        // New Tag should have been added to the two existing tags
        $this->assertEquals(3, count($data['tags']));
    }

    public function testUpdate()
    {
        $faker = $this->getFaker();

        /** @var Entity\Article $article */
        $article = FactoryMuffin::create(Entity\Article::class);
        $articleId = $article->getId();

        $title = $faker->sentence();
        $slug = $faker->word;
        $content = $faker->sentence();
        $active = $faker->boolean();
        $tags = [];

        $values = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'active' => $active,
            'tags' => $tags,
        ];

        $response = $this->client->request(
            'PUT',
            sprintf('/api/articles/%s', $articleId),
            [
                'body' => $this->createStreamFromArray($values),
            ]
        );

        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->request(
            'GET',
            sprintf('/api/articles/%s', $articleId)
        );

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($this->readResponse($response), true);

        $article = $responseContent['result']['data'];

        $this->assertSame($title, $article['title']);
        $this->assertSame($slug, $article['slug']);
        $this->assertSame($content, $article['content']);
        $this->assertSame($active, $article['active']);
        $this->assertSame(count($tags), count($article['tags']));
    }
}
