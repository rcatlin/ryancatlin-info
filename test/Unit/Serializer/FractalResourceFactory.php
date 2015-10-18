<?php

namespace RCatlin\Blog\Test\Unit\Serializer;

use League\Fractal\Resource;
use League\Fractal\TransformerAbstract;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Test\Unit\BuildsMocks;

class FractalResourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;

    public function testCreateItem()
    {
        $entityClass = \stdClass::class;
        $entity = new \stdClass();

        $transformer = $this->getMockTransformer();

        $container = $this->getMockTransformerContainer();
        $container->expects($this->once())
            ->method('getTransformer')
            ->with($entityClass)
            ->willReturn($transformer)
        ;

        $factory = new Serializer\FractalResourceFactory($container);

        $result = $factory->createItem($entityClass, $entity);

        $this->assertInstanceOf(Resource\Item::class, $result);
    }

    public function testCreateCollection()
    {
        $entityClass = \stdClass::class;
        $entities = [new \stdClass()];

        $transformer = $this->getMockTransformer();

        $container = $this->getMockTransformerContainer();
        $container->expects($this->once())
            ->method('getTransformer')
            ->with($entityClass)
            ->willReturn($transformer)
        ;

        $factory = new Serializer\FractalResourceFactory($container);

        $result = $factory->createCollection($entityClass, $entities);

        $this->assertInstanceOf(Resource\Collection::class, $result);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\TransformerContainer
     */
    private function getMockTransformerContainer()
    {
        return $this->buildMock(Serializer\TransformerContainer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TransformerAbstract
     */
    private function getMockTransformer()
    {
        return $this->buildMock(TransformerAbstract::class);
    }
}
