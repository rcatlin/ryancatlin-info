<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use RCatlin\Blog\Test\CreatesGuzzleStream;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\ReadsResponseContent;

class ArticleUpdateControllerTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use ReadsResponseContent;

    public function testUpdate()
    {
        $faker = $this->getFaker();

        $active = $faker->boolean();

        // Create Article And Tag
        $response = $this->client->request('POST', '/api/articles', [
            'body' => $this->createStreamFromArray(
                [
                    'slug' => $faker->word,
                    'title' => $faker->sentence,
                    'content' => $faker->sentence,
                    'tags' => [
                        [
                            'name' => $faker->word,
                        ],
                    ],
                    'active' => $active,
                ]
            ),
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        // Get Article ID
        $content = json_decode($this->readResponse($response), true);

        $data = $content['result']['data'];
        $articleId = $data['id'];
        $tagId = $data['tags'][0]['id'];

        $newSlug = $faker->word;
        $newTitle = $faker->sentence;
        $newContent = $faker->sentence;
        $newActive = !$active;
        $newTagName = $faker->word;

        // Update
        $body =
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
        $this->assertEquals(1, count($data['tags']));

        $tagData = $data['tags'][0];

        $this->assertEquals($tagId, $tagData['id']);
        $this->assertEquals($newTagName, $tagData['name']);
    }
}
