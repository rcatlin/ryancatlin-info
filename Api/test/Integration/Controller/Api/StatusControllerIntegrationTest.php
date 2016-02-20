<?php

namespace RCatlin\Api\Test\Integration\Controller\Api;

use RCatlin\Api\Test\Integration\AbstractIntegrationTest;
use RCatlin\Api\Test\ReadsResponseContent;
use Teapot\StatusCode;

class StatusControllerIntegrationTest extends AbstractIntegrationTest
{
    use ReadsResponseContent;

    public function testGetStatus()
    {
        $response = $this->client->get('/api/status');

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());
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
