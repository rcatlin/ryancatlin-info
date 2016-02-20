<?php

namespace RCatlin\Api\ReverseTransformer\Entity;

use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\ReverseTransformer;

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
     * @param bool  $overrideEmbedded
     *
     * @return null|object|Entity\Tag
     */
    public function reverseTransform(array $values, $overrideEmbedded = true)
    {
        // Existing Tag
        if (array_key_exists('id', $values)) {
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
     * @param bool  $overrideEmbedded
     *
     * @return Entity\Tag[]
     */
    public function reverseTransformAll(array $multipleValues, $overrideEmbedded = true)
    {
        $tags = [];
        foreach ($multipleValues as $values) {
            $tag = $this->reverseTransform($values, $overrideEmbedded);

            if ($tag !== null) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }
}
