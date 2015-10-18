<?php

namespace RCatlin\Blog\Serializer;

use Assert\Assertion;
use League\Fractal\Resource;
use League\Fractal\TransformerAbstract;

class FractalResourceFactory
{
    /**
     * @var TransformerContainer
     */
    private $container;

    /**
     * @param TransformerContainer $container
     */
    public function __construct(TransformerContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $entityClass
     * @param object $entity
     *
     * @return Resource\Item
     */
    public function createItem($entityClass, $entity)
    {
        Assertion::string($entityClass);
        Assertion::isInstanceOf($entity, $entityClass);

        /** @var TransformerAbstract $transformer */
        $transformer = $this->container->getTransformer($entityClass);

        return new Resource\Item($entity, $transformer);
    }

    /**
     * @param string $entityClass
     * @param object[] $entities
     *
     * @return Resource\Collection
     */
    public function createCollection($entityClass, array $entities)
    {
        Assertion::string($entityClass);
        Assertion::allIsInstanceOf($entities, $entityClass);

        /** @var TransformerAbstract $transformer */
        $transformer = $this->container->getTransformer($entityClass);

        return new Resource\Collection($entities, $transformer);
    }
}
