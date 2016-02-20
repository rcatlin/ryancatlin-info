<?php

namespace RCatlin\Api\Test\Integration\Controller\Api;

use RCatlin\Api\Test\CreatesGuzzleStream;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\Integration\AbstractIntegrationTest;
use RCatlin\Api\Test\ReadsResponseContent;
use Teapot\StatusCode;

class ArticleControllersIntegrationTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use ReadsResponseContent;

    public function testCreateGetAndDeleteArticleWithATag()
    {
        $faker = $this->getFaker();
        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->sentence;
        $tagName = $faker->word;
        $active = $faker->boolean();

        // Create Article And Tag
        $response = $this->client->request('POST', '/api/articles', [
            'body' => $this->createStreamFromArray(
                [
                    'slug' => $slug,
                    'title' => $title,
                    'content' => $content,
                    'tags' => [
                        [
                            'name' => $tagName,
                        ],
                    ],
                    'active' => $active,
                ]
            ),
        ]);

        $this->assertEquals(StatusCode::CREATED, $response->getStatusCode());

        $responseContent = json_decode($this->readResponse($response), true);

        $data = $responseContent['result']['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals($slug, $data['slug']);
        $this->assertEquals($title, $data['title']);
        $this->assertEquals($content, $data['content']);
        $this->assertEquals(1, count($data['tags']));
        $this->assertArrayHasKey('id', $data['tags'][0]);
        $this->assertEquals($tagName, $data['tags'][0]['name']);
        $this->assertEquals($active, $data['active']);

        $articleId = $data['id'];
        $tagId = $data['tags'][0]['id'];

        // Get Article
        $response = $this->client->request('GET', sprintf(
            '/api/articles/%s', $articleId
        ));

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());

        // Get Tag Created From Creating Article
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());

        // Delete Article
        $response = $this->client->request('DELETE', sprintf(
            '/api/articles/%s', $articleId
        ));

        $this->assertEquals(StatusCode::NO_CONTENT, $response->getStatusCode());

        // Ensure Article no longer exists
        $response = $this->client->request('GET', sprintf(
            '/api/articles/%s', $articleId
        ));

        $this->assertEquals(StatusCode::NOT_FOUND, $response->getStatusCode());

        // Ensure Tag was not Deleted with Article
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());

        // Delete Tag
        $response = $this->client->request('DELETE', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::NO_CONTENT, $response->getStatusCode());

        // Ensure Tag is Deleted
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::NOT_FOUND, $response->getStatusCode());
    }
}
