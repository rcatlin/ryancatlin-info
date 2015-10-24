<?php

namespace RCatlin\Blog\Test\Unit\Serializer;

use League\Container\Container;
use League\Fractal\TransformerAbstract;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Transformer;

class TransformerContainerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testGetTransformer()
    {
        $alias = $this->getFaker()->word;
        $transformer = $this->getMockTransformer();

        $container = $this->getMockContainer();
        $container->expects($this->once())
            ->method('get')
            ->with($alias)
            ->willreturn($transformer)
        ;

        $transformerContainer = new Transformer\TransformerContainer($container);

        $this->assertSame($transformer, $transformerContainer->getTransformer($alias));
    }

    public function testHasTransformer()
    {
        $faker = $this->getFaker();

        $alias = $faker->word;
        $hasTransformer = $faker->boolean();

        $container = $this->getMockContainer();
        $container->expects($this->once())
            ->method('has')
            ->with($alias)
            ->willreturn($hasTransformer)
        ;

        $transformerContainer = new Transformer\TransformerContainer($container);

        $this->assertSame($hasTransformer, $transformerContainer->hasTransformer($alias));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Container
     */
    private function getMockContainer()
    {
        return $this->buildMock(Container::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TransformerAbstract
     */
    private function getMockTransformer()
    {
        return $this->buildMock(TransformerAbstract::class);
    }
}
