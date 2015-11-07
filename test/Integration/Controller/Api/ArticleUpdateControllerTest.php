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
}
