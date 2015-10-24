<?php

namespace RCatlin\Blog\Transformer;

use Assert\Assertion;
use League\Container\Container;
use RCatlin\Blog\ServiceProvider;

class TransformerContainer
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container ?: new Container();

        $this->container->addServiceProvider(new ServiceProvider\TransformerServiceProvider());
    }

    /**
     * @param string $alias
     *
     * @return mixed|object
     */
    public function getTransformer($alias)
    {
        Assertion::string($alias);

        return $this->container->get($alias);
    }

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function hasTransformer($alias)
    {
        Assertion::string($alias);

        return $this->container->has($alias);
    }
}
