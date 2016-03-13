<?php

namespace RCatlin\Api\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Api\Entity;
use RCatlin\Api\Test\CreatesGuzzleStream;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\Integration\AbstractIntegrationTest;
use RCatlin\Api\Test\LoadsFactoryMuffinFactories;
use RCatlin\Api\Test\ReadsResponseContent;
use Teapot\StatusCode;

class TagUpdateControllerTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use LoadsFactoryMuffinFactories;
    use ReadsResponseContent;

    public function testUpdate()
    {
        $faker = $this->getFaker();

        /** var Entity\Tag $tag */
        $tag = FactoryMuffin::create(Entity\Tag::class);
        $tagId = $tag->getId();

        $name = $faker->word;

        $values = ['name' => $name];

        // PUT
        $response = $this->client->request(
            'PUT',
            sprintf('/api/tags/%s', $tagId),
            [
                'body' => $this->createStreamFromArray($values),
            ]
        );

        $this->assertEquals(StatusCode::ACCEPTED, $response->getStatusCode());

        // GET
        $response = $this->client->request(
            'GET',
            sprintf('/api/tags/%s', $tagId)
        );

        $this->assertSame(StatusCode::OK, $response->getStatusCode());

        $content = $this->readResponse($response);

        $this->assertEquals(
            json_encode(
                [
                    'result' => [
                        'data' => [
                            'id' => $tagId,
                            'name' => $name,
                        ],
                    ],
                ]
            ),
            $content
        );
    }
}
