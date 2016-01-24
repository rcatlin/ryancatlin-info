<?php

namespace RCatlin\Blog\Test\Unit\Serializer;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Test\Unit\BuildsMocks;

class ScopeBuilderTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;

    public function testBuildCollection()
    {
        $entityClass = \stdClass::class;
        $entities = [new \stdClass()];
        $collection = $this->getMockCollection();
        $scope = $this->getMockScope();

        $factory = $this->getMockFractalResourceFactory();
        $factory->expects($this->once())
            ->method('createCollection')
            ->with($entityClass, $entities)
            ->willReturn($collection)
        ;

        $manager = $this->getMockManager();
        $manager->expects($this->once())
            ->method('createData')
            ->willReturn($scope)
        ;

        $builder = new Serializer\ScopeBuilder($manager, $factory);

        $result = $builder->buildCollection($entityClass, $entities);

        $this->assertSame($result, $scope);
    }

    public function testBuildItem()
    {
        $entityClass = \stdClass::class;
        $entity = new \stdClass();
        $item = $this->getMockItem();
        $scope = $this->getMockScope();

        $factory = $this->getMockFractalResourceFactory();
        $factory->expects($this->once())
            ->method('createItem')
            ->with($entityClass, $entity)
            ->willReturn($item)
        ;

        $manager = $this->getMockManager();
        $manager->expects($this->once())
            ->method('createData')
            ->with($item)
            ->willReturn($scope)
        ;

        $builder = new Serializer\ScopeBuilder($manager, $factory);

        $result = $builder->buildItem($entityClass, $entity);

        $this->assertSame($result, $scope);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Manager
     */
    private function getMockManager()
    {
        return $this->buildMock(Manager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\FractalResourceFactory
     */
    private function getMockFractalResourceFactory()
    {
        return $this->buildMock(Serializer\FractalResourceFactory::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Collection
     */
    private function getMockCollection()
    {
        return $this->buildMock(Collection::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Item
     */
    private function getMockItem()
    {
        return $this->buildMock(Item::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Scope
     */
    private function getMockScope()
    {
        return $this->buildMock(Scope::class);
    }
}
