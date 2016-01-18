<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\FactoryMuffin\Facade as FactoryMuffin;
use League\Fractal\Scope;
use Particle\Validator\ValidationResult;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Test\AbstractRequiresContainerTest;
use RCatlin\Blog\Test\CreatesRequest;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\LoadsFactoryMuffinFactories;
use RCatlin\Blog\Test\ReadsResponseContent;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

class ArticleUpdateControllerTest extends AbstractRequiresContainerTest
{
    use BuildsMocks;
    use CreatesRequest;
    use HasFaker;
    use LoadsFactoryMuffinFactories;
    use ReadsResponseContent;

    public function testUpdate()
    {
        // Create Article Entity from FactoryMuffin
        $article = FactoryMuffin::create(Entity\Article::class);
        $id = $article->getId();

        $faker = $this->getFaker();

        $slug = $faker->word;
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $active = $faker->boolean();

        $data = [
            'slug' => $slug,
            'title' => $title,
            'content' => $content,
            'active' => $active,
        ];

        $serializedArticle = ['serialized-article'];

        $article = $this->getMockArticle();

        $validationResult = $this->getMockValidationResult();
        $validationResult->expects($this->once())
            ->method('isNotValid')
            ->willReturn(false)
        ;

        $validator = $this->getMockValidator();
        $validator->expects($this->once())
            ->method('validate')
            ->with($data)
            ->willReturn($validationResult)
        ;

        $transformData = $data;
        $transformData['id'] = $id;

        $reverseTransformer = $this->getMockReverseTransformer();
        $reverseTransformer->expects($this->once())
            ->method('reverseTransform')
            ->with($transformData, true)
            ->willReturn($article)
        ;

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('flush')
            ->with($article)
        ;

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn($serializedArticle)
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->with(Entity\Article::class, $article)
            ->willReturn($scope)
        ;

        // Create Controller
        $controller = new Controller\Api\ArticleUpdateController(
            $reverseTransformer,
            $validator,
            $entityManager,
            $scopeBuilder
        );

        $request = $this->createRequest(json_encode($data));

        // Call Our Test Method
        $response = $controller->update($request, new Response(), ['id' => $id]);

        $this->assertSame(StatusCode::ACCEPTED, $response->getStatusCode());

        $content = $this->readControllerResponse($response);

        $this->assertSame(
            json_encode(
                [
                    'result' => $serializedArticle,
                ]
            ),
            $content
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Scope
     */
    public function getMockScope()
    {
        return $this->buildMock(Scope::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Article
     */
    public function getMockArticle()
    {
        return $this->buildMock(Entity\Article::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ValidationResult
     */
    public function getMockValidationResult()
    {
        return $this->buildMock(ValidationResult::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ReverseTransformer\Entity\ArticleReverseTransformer
     */
    public function getMockReverseTransformer()
    {
        return $this->buildMock(ReverseTransformer\Entity\ArticleReverseTransformer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Validator\Entity\ArticleValidator
     */
    public function getMockValidator()
    {
        return $this->buildMock(Validator\Entity\ArticleValidator::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    public function getMockEntityManager()
    {
        return $this->buildMock(EntityManager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\ScopeBuilder
     */
    public function getMockScopeBuilder()
    {
        return $this->buildMock(Serializer\ScopeBuilder::class);
    }
}
