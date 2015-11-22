<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\CreatesGuzzleStream;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\LoadsFactoryMuffinFactories;
use RCatlin\Blog\Test\ReadsResponseContent;

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

        $this->assertEquals(202, $response->getStatusCode());

        // GET
        $response = $this->client->request(
            'GET',
            sprintf('/api/tags/%s', $tagId)
        );

        $this->assertSame(200, $response->getStatusCode());

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
