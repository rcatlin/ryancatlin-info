<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Fractal\Scope;
use Particle\Validator\ValidationResult;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Test\CreatesRequest;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\ReadsResponseContent;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Response;

class TagCreateControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use CreatesRequest;
    use HasFaker;
    use ReadsResponseContent;

    public function testCreate()
    {
        $content = ['tag-values'];

        $tag = $this->getMockTag();

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn(['serialized-tag'])
        ;

        $validationResult = $this->getMockValidationResult();
        $validationResult->expects($this->once())
            ->method('isNotValid')
            ->willReturn(false)
        ;

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($tag)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $tagReverseTransformer = $this->getMockTagReverseTransformer();
        $tagReverseTransformer->expects($this->once())
            ->method('reverseTransform')
            ->with(['tag-values'])
            ->willReturn($tag)
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->with(Entity\Tag::class, $tag)
            ->willReturn($scope)
        ;

        $validator = $this->getMockTagValidator();
        $validator->expects($this->once())
            ->method('validate')
            ->with($content)
            ->willReturn($validationResult)
        ;
        $controller = new Controller\Api\TagCreateController(
            $entityManager,
            $tagReverseTransformer,
            $scopeBuilder,
            $validator
        );

        $request = $this->createRequest(json_encode($content));

        $response = $controller->create($request, new Response());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals(
            json_encode(
                [
                    'result' => ['serialized-tag'],
                ]
            ),
            $this->readControllerResponse($response)
        );
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
     * @return \PHPUnit_Framework_MockObject_MockObject|ReverseTransformer\Entity\TagReverseTransformer
     */
    private function getMockTagReverseTransformer()
    {
        return $this->buildMock(ReverseTransformer\Entity\TagReverseTransformer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Validator\Entity\TagValidator
     */
    private function getMockTagValidator()
    {
        return $this->buildMock(Validator\Entity\TagValidator::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    private function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Scope
     */
    private function getMockScope()
    {
        return $this->buildMock(Scope::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ValidationResult
     */
    private function getMockValidationResult()
    {
        return $this->buildMock(ValidationResult::class);
    }
}
