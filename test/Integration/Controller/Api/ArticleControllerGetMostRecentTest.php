<?php

namespace RCatlin\Blog\Test\Integration\Controller\Api;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\CreatesGuzzleStream;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Integration\AbstractIntegrationTest;
use RCatlin\Blog\Test\ReadsResponseContent;

class ArticleControllerGetMostRecentTest extends AbstractIntegrationTest
{
    use CreatesGuzzleStream;
    use HasFaker;
    use ReadsResponseContent;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        FactoryMuffin::loadFactories(
            __DIR__ . '/../../../Factory'
        );

        $entityManager = self::$entityManager;
        FactoryMuffin::setCustomSaver(function ($object) use ($entityManager) {
            $entityManager->persist($object);
            $entityManager->flush($object);

            return true;
        });
    }

    public function testGetMostRecent()
    {
        /** @var Entity\Article $article0 */
        $article0 = FactoryMuffin::create(Entity\Article::class, [
            'active' => true,
            'createdAt' => 'datetime|-1 day',
        ]);

        /** @var Entity\Article $article1 */
        $article1 = FactoryMuffin::create(Entity\Article::class, [
            'active' => true,
            'createdAt' => 'datetime|now',
        ]);

        $response = $this->client->get('/api/articles/mostrecent');

        $this->assertSame(200, $response->getStatusCode());

        $content = json_decode($this->readResponse($response), true);

        $this->assertSame($article1->getId(), $content['result']['data']['id']);
    }

    public static function tearDownBeforeClass()
    {
        $entityManager = self::$entityManager;
        FactoryMuffin::setCustomDeleter(function ($object) use ($entityManager) {
            $entityManager->remove($object);
            $entityManager->flush();
        });
        FactoryMuffin::deleteSaved();

        parent::tearDownAfterClass();
    }
}
