<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;

class ArticleControllersIntegrationTest extends AbstractIntegrationTest
{
    use HasFaker;

    public function testCreateGetAndDeleteArticleWithATag()
    {
        $faker = $this->getFaker();
        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->sentence;
        $tagName = $faker->word;
        $active = $faker->boolean();

        $values = [
            'slug' => $slug,
            'title' => $title,
            'content' => $content,
            'tags' => [
                [
                    'name' => $tagName,
                ],
            ],
            'active' => $active,
        ];

        // Create Article And Tag
        $body = \GuzzleHttp\Psr7\stream_for(json_encode($values));
        $response = $this->client->request('POST', '/api/articles', ['body' => $body]);

        $this->assertEquals(201, $response->getStatusCode());

        $responseContent = json_decode($response->getBody()->getContents(), true);

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

        $this->assertEquals(200, $response->getStatusCode());

        // Get Tag Created From Creating Article
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(200, $response->getStatusCode());

        // Delete Article
        $response = $this->client->request('DELETE', sprintf(
            '/api/articles/%s', $articleId
        ));

        $this->assertEquals(204, $response->getStatusCode());

        // Ensure Article no longer exists
        $response = $this->client->request('GET', sprintf(
            '/api/articles/%s', $articleId
        ));

        $this->assertEquals(404, $response->getStatusCode());

        // Ensure Tag was not Deleted with Article
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(200, $response->getStatusCode());

        // Delete Tag
        $response = $this->client->request('DELETE', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(204, $response->getStatusCode());

        // Ensure Tag is Deleted
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(404, $response->getStatusCode());
    }
}
