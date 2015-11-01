<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use League\Fractal\Scope;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\ReadsResponseContent;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class TagGetControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;
    use ReadsResponseContent;

    public function testGet()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber();

        $tag = $this->getMockTag();

        $scope = $this->getMockScope();
        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn(['serialized-tag'])
        ;

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->with(Entity\Tag::class, $tag)
            ->willReturn($scope)
        ;

        $repository = $this->getMockTagRepository();
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($tag)
        ;

        $controller = new Controller\Api\TagGetController($scopeBuilder, $repository);

        $response = $controller->get(new Request(), new Response(), ['id' => $id]);

        $this->assertEquals(200, $response->getStatusCode());
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
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\ScopeBuilder
     */
    private function getMockScopeBuilder()
    {
        return $this->buildMock(Serializer\ScopeBuilder::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\TagRepository
     */
    private function getMockTagRepository()
    {
        return $this->buildMock(Repository\TagRepository::class);
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
}
