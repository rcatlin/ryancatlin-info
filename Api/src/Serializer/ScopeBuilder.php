<?php

namespace RCatlin\Blog\Serializer;

use Assert\Assertion;
use League\Fractal\Manager;

class ScopeBuilder
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var FractalResourceFactory
     */
    private $resourceFactory;

    /**
     * @param Manager                $manager
     * @param FractalResourceFactory $resourceFactory
     */
    public function __construct(Manager $manager, FractalResourceFactory $resourceFactory)
    {
        $this->manager = $manager;
        $this->resourceFactory = $resourceFactory;
    }

    /**
     * @param $entityClass
     * @param array $entities
     *
     * @return \League\Fractal\Scope
     */
    public function buildCollection($entityClass, array $entities)
    {
        Assertion::string($entityClass);
        Assertion::allIsInstanceOf($entities, $entityClass);

        return $this->manager->createData(
            $this->resourceFactory->createCollection($entityClass, $entities)
        );
    }

    /**
     * @param $entityClass
     * @param object $entity
     *
     * @return \League\Fractal\Scope
     */
    public function buildItem($entityClass, $entity)
    {
        Assertion::string($entityClass);
        Assertion::isInstanceOf($entity, $entityClass);

        return $this->manager->createData(
            $this->resourceFactory->createItem($entityClass, $entity)
        );
    }
}
