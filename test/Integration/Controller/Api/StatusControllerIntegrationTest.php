<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\ReadsResponseContent;

class StatusControllerIntegrationTest extends AbstractIntegrationTest
{
    use ReadsResponseContent;

    public function testGetStatus()
    {
        $response = $this->client->get('/api/status');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            json_encode(
                [
                    'result' => [
                        'status' => 'ok',
                    ],
                ]
            ),
            $response->getBody()->getContents()
        );
    }
}
