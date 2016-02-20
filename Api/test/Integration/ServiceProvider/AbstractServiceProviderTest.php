<?php

namespace RCatlin\Api\Test\Integration\ServiceProvider;

use Assert\Assertion;
use League\Container\Container;

abstract class AbstractServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $alias
     * @param $expectedClass
     *
     * @dataProvider providesDataProvider
     */
    public function testProvides($alias, $expectedClass)
    {
        Assertion::string($alias);
        Assertion::string($expectedClass);

        $container = new Container();
        foreach ($this->getServiceProviders() as $serviceProvider) {
            $container->addServiceProvider($serviceProvider);
        }

        $this->assertInstanceOf($expectedClass, $container->get($alias));
    }

    /**
     * @return array
     */
    abstract public function getServiceProviders();

    /**
     * @return array
     */
    abstract public function providesDataProvider();
}
