<?php

namespace MyProject\Bundle\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\Exception\TransformationFailedException;
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
    public function transform($value = null)
    {
        if ($value === null) {
            return '';
        }

        if (!is_object($value)) {
            throw new TransformationFailedException(
                'Transform value must be of class Doctrine\Common\Collections\ArrayCollection.'
            );
        } elseif (!($value instanceof ArrayCollection)) {
            throw new TransformationFailedException(
                sprintf(
                    'Transform value must be of class Doctrine\Common\Collections\ArrayCollection. \'%s\' given.',
                    get_class($value)
                )
            );
        }

        return $this->createStringFromTagCollection($value);
    }

    /**
     * Reverse transforms a string of comma delimited
     * tag names into an ArrayCollection of Tag objects
     *
     * @param ArrayCollection|null $value
     *
     * @return string
     */
    public function reverseTransform($value = null)
    {
        if ($value === null) {
            return $this->createArrayCollection();
        }

        if (!is_string($value)) {
            throw new TransformationFailedException(
                'Reverse transform value must be string.'
            );
        }

        return $this->createTagCollectionFromString($value);
    }

    /**
     * @param ArrayCollection $collectoin
     *
     * @return string
     */
    protected function createStringFromTagCollection(ArrayCollection $collection)
    {
        return implode(
            ',',
            array_map(
                function (Tag $tag) {
                    return $tag->getName();
                },
                $collection->toArray()
            )
        );
    }

    /**
     * @param string $str
     *
     * @return ArrayCollection
     */
    protected function createTagCollectionFromString($str)
    {
        $self = $this;

        $tags = array();
        foreach (explode(',', $str) as $name) {
            $name = trim($name);

            if ($name === '') {
                continue;
            }

            $tags[] = $self->createNewTag($name);
        }

        return $this->createArrayCollection($tags);
    }

    /**
     * @param string $name
     *
     * @return Tag
     */
    protected function createNewTag($name)
    {
        $tag = new Tag();
        $tag->setName($name);

        return $tag;
    }

    /**
     * @param array $values
     *
     * @return ArrayCollection
     */
    protected function createArrayCollection(array $values = array())
    {
        return new ArrayCollection($values);
    }
}
