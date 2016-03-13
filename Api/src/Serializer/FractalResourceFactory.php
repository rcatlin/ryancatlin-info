<?php

namespace RCatlin\Api\Serializer;

use Assert\Assertion;
use League\Fractal\Resource;
use League\Fractal\TransformerAbstract;
use RCatlin\Api\Transformer;

class FractalResourceFactory
{
    /**
     * @var Transformer\TransformerContainer
     */
    private $container;

    /**
     * @param Transformer\TransformerContainer $container
     */
    public function __construct(Transformer\TransformerContainer $container)
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
     * @param string   $entityClass
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
