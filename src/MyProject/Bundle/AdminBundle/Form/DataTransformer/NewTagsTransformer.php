<?php

namespace MyProject\Bundle\AdminBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use MyProject\Bundle\MainBundle\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;

class NewTagsTransformer implements DataTransformerInterface
{
    /**
     * Transforms objects (tags) to a comma delimited string
     *
     * @param ArrayCollection
     */
    public function transform($value)
    {
        if ($value === null) {
            return;
        }

        return implode(
            ',',
            array_map(
                function (Tag $tag) {
                    return $tag->getName();
                },
                $value->toArray()
            )
        );
    }

    public function reverseTransform($value)
    {
        if ($value === null) {
            return;
        }

        return array_map(
            function ($name) {
                return $this->createNewTag(trim($name));
            },
            explode(',', $value)
        );
    }

    protected function createNewTag($name)
    {
        $tag = new Tag();
        $tag->setName($name);

        return $tag;
    }
}
