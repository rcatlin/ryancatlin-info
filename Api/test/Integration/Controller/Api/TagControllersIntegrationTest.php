<?php

namespace RCatlin\Api\Test\Integration\Controller\Api;

use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\Integration\AbstractIntegrationTest;
use Teapot\StatusCode;

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

        $this->assertEquals(StatusCode::CREATED, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);

        $data = $content['result']['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        $tagId = $data['id'];

        // Get Tag
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());

        $content = json_decode($response->getBody()->getContents(), true);
        $data = $content['result']['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);

        // Delete Tag
        $response = $this->client->request('DELETE', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::NO_CONTENT, $response->getStatusCode());

        // Ensure Tag No Longer Exists
        $response = $this->client->request('GET', sprintf(
            '/api/tags/%s', $tagId
        ));

        $this->assertEquals(StatusCode::NOT_FOUND, $response->getStatusCode());
    }
}
