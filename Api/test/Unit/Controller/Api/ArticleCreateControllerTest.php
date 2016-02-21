<?php

namespace RCatlin\Api\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Container\Container;
use League\Fractal\Scope;
use RCatlin\Api\Controller;
use RCatlin\Api\Entity;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Serializer;
use RCatlin\Api\ServiceProvider;
use RCatlin\Api\Test\CreatesRequest;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\ReadsResponseContent;
use RCatlin\Api\Test\Unit\BuildsMocks;
use RCatlin\Api\Validator;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

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
        $article = $this->getMockArticle();

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn($serializedArticle)
        ;

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($article)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $reverseTransformer = $this->getMockArticleReverseTransformer();
        $reverseTransformer->expects($this->once())
            ->method('reverseTransform')
            ->with($body)
            ->willReturn($article)
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->with(Entity\Article::class, $article)
            ->willReturn($scope)
        ;

        $controller = new Controller\Api\ArticleCreateController(
            $entityManager,
            $reverseTransformer,
            $scopeBuilder,
            $this->articleValidator
        );

        $request = $this->createRequest(json_encode($body));

        $response = $controller->create($request, new ApiResponse());

        $this->assertEquals(StatusCode::CREATED, $response->getStatusCode());
        $this->assertEquals(
            json_encode([
                'result' => $serializedArticle,
            ]),
            $this->readControllerResponse($response)
        );
    }

    public function testCreateWithBadRequestJson()
    {
        $controller = new Controller\Api\ArticleCreateController(
            $this->getMockEntityManager(),
            $this->getMockArticleReverseTransformer(),
            $this->getMockScopeBuilder(),
            $this->articleValidator
        );

        $response = $controller->create(new Request(), new ApiResponse());

        $this->assertEquals(StatusCode::BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateAndValidationFails()
    {
        $controller = new Controller\Api\ArticleCreateController(
            $this->getMockEntityManager(),
            $this->getMockArticleReverseTransformer(),
            $this->getMockScopeBuilder(),
            $this->articleValidator
        );

        $request = $this->createRequest(json_encode([
            'bad' => 'article request data',
        ]));

        $response = $controller->create($request, new ApiResponse());

        $this->assertEquals(StatusCode::BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    private function getMockEntityManager()
    {
        return $this->buildMock(EntityManager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ReverseTransformer\Entity\ArticleReverseTransformer
     */
    private function getMockArticleReverseTransformer()
    {
        return $this->buildMock(ReverseTransformer\Entity\ArticleReverseTransformer::class);
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Article
     */
    private function getMockArticle()
    {
        return $this->buildMock(Entity\Article::class);
    }
}
