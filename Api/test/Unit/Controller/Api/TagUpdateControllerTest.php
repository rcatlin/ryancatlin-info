<?php

namespace RCatlin\Api\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Fractal\Scope;
use Particle\Validator\ValidationResult;
use RCatlin\Api\Controller;
use RCatlin\Api\Entity;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Serializer;
use RCatlin\Api\Test\CreatesRequest;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\ReadsResponseContent;
use RCatlin\Api\Test\Unit\BuildsMocks;
use RCatlin\Api\Validator;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

class TagUpdateControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use CreatesRequest;
    use HasFaker;
    use ReadsResponseContent;

    public function testUpdate()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber();
        $name = $faker->word;

        $content = ['name' => $name];
        $serializedTag = ['serialized-tag'];

        $tag = $this->getMockTag();

        $validationResult = $this->getMockValidationResult();
        $validationResult->expects($this->once())
            ->method('isNotValid')
            ->willReturn(false)
        ;

        $validator = $this->getMockValidator();
        $validator->expects($this->once())
            ->method('validate')
            ->with($content, Validator\Context::UPDATE)
            ->willReturn($validationResult)
        ;

        $reverseTransformer = $this->getMockReverseTransformer();
        $reverseTransformer->expects($this->once())
            ->method('reverseTransform')
            ->with([
                'id' => $id,
                'name' => $name,
            ])
            ->willReturn($tag)
        ;

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('flush')
            ->with($tag)
        ;

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn($serializedTag)
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->willReturn($scope)
        ;

        // Initialize Controller
        $controller = new Controller\Api\TagUpdateController(
            $entityManager,
            $scopeBuilder,
            $reverseTransformer,
            $validator
        );

        // Create Request with Tag Data
        $request = $this->createRequest(json_encode($content));

        // Call Our Test Method
        $response = $controller->update($request, new Response(), ['id' => $id]);

        $this->assertEquals(StatusCode::ACCEPTED, $response->getStatusCode());

        $content = $this->readControllerResponse($response);

        $this->assertEquals(
            json_encode(
                [
                    'result' => $serializedTag,
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
     * @return \PHPUnit_Framework_MockObject_MockObject|ValidationResult
     */
    public function getMockValidationResult()
    {
        return $this->buildMock(ValidationResult::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    public function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ReverseTransformer\Entity\TagReverseTransformer
     */
    public function getMockReverseTransformer()
    {
        return $this->buildMock(ReverseTransformer\Entity\TagReverseTransformer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Validator\Entity\TagValidator
     */
    public function getMockValidator()
    {
        return $this->buildMock(Validator\Entity\TagValidator::class);
    }
}
