<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\Fractal\Scope;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\ServiceProvider;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Test\Unit\CreatesRequest;
use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Test\Unit\ReadsResponseContent;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleCreateControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;
    use ReadsResponseContent;
    use CreatesRequest;

    /**
     * @var Validator\Entity\ArticleValidator
     */
    private $articleValidator;

    public function setUp()
    {
        $container = new Container();
        $container->addServiceProvider(ServiceProvider\ValidatorServiceProvider::class);

        /* @var Validator\Entity\ArticleValidator articleValidator */
        $this->articleValidator = $container->get(Validator\Entity\ArticleValidator::class);
    }

    public function testCreate()
    {
        $faker = $this->getFaker();

        $body = [
            'slug' => $faker->word,
            'title' => $faker->sentence,
            'content' => $faker->sentence,
            'tags' => [],
            'active' => $faker->boolean(),
        ];
        $serializedArticle = ['serialized-article'];

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn($serializedArticle)
        ;

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Entity\Article::class))
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->willReturn($scope)
        ;

        $controller = new Controller\Api\ArticleCreateController(
            $entityManager,
            $scopeBuilder,
            $this->articleValidator
        );

        $request = $this->createRequest(json_encode($body));

        $response = $controller->create($request, new Response());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
            json_encode([
                'result' => $serializedArticle,
            ]),
            $this->readResponseContent($response)
        );
    }

    public function testCreateWithBadRequestJson()
    {
        $controller = new Controller\Api\ArticleCreateController(
            $this->getMockEntityManager(),
            $this->getMockScopeBuilder(),
            $this->articleValidator
        );

        $response = $controller->create(new Request(), new Response());

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testCreateAndValidationFails()
    {
        $controller = new Controller\Api\ArticleCreateController(
            $this->getMockEntityManager(),
            $this->getMockScopeBuilder(),
            $this->articleValidator
        );

        $request = $this->createRequest(json_encode([
            'bad' => 'article request data',
        ]));

        $response = $controller->create($request, new Response());

        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    private function getMockEntityManager()
    {
        return $this->buildMock(EntityManager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\ScopeBuilder
     */
    private function getMockScopeBuilder()
    {
        return $this->buildMock(Serializer\ScopeBuilder::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Scope
     */
    private function getMockScope()
    {
        return $this->buildMock(Scope::class);
    }
}