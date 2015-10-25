<?php

namespace RCatlin\Blog\ReverseTransformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;

class TagReverseTransformer implements ReverseTransformer\ReverseTransformerInterface
{
    /**
     * @var Repository\TagRepository
     */
    private $repository;

    /**
     * @param Repository\TagRepository $repository
     */
    public function __construct(Repository\TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $values
     *
     * @return null|object|Entity\Tag
     */
    public function reverseTransform(array $values)
    {
        // Existing Tag
        if (isset($values['id'])) {
            /** @var null|Entity\Tag $tag */
            $tag = $this->repository->find($values['id']);

            if ($tag === null) {
                // TODO - Throw Exception
                return;
            }

            if (isset($values['name'])) {
                $tag->setName($values['name']);
            }

            return $tag;
        }

        // New Tag
        return Entity\Tag::fromArray($values);
    }

    /**
     * @param array $multipleValues
     *
     * @return Entity\Article[]
     */
    public function reverseTransformAll(array $multipleValues)
    {
        $tags = [];
        foreach ($multipleValues as $values) {
            $tags[] = $this->reverseTransform($values);
        }

        return $tags;
    }
}
