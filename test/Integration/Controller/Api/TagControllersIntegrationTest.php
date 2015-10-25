<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;

class TagControllersIntegrationTest extends AbstractIntegrationTest
{
    use HasFaker;

    public function testCreateGetAndDeleteTag()
    {
        $name = $this->getFaker()->word;

        $tag = [
            'name' => $name,
        ];

        $body = \GuzzleHttp\Psr7\stream_for(json_encode($tag));

        // Create Tag
        $response = $this->client->request('POST', '/api/tags', ['body' => $body]);

        $this->assertEquals(201, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);

        $data = $content['result']['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $tagId = $data['id'];

        // Get Tag
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);
        $data = $content['result']['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        // Delete Tag
        $response = $this->client->request('DELETE', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(204, $response->getStatusCode());

        // Ensure Tag No Longer Exists
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(404, $response->getStatusCode());
    }
}
