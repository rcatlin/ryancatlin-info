<?php

namespace MyProject\Tests\Bundle\AdminBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use MyProject\Bundle\AdminBundle\Form\DataTransformer\NewTagsTransformer;
use MyProject\Bundle\MainBundle\Entity\Tag;
use MyProject\Tests\Bundle\AdminBundle\AdminBundleTestCase;

class NewTagsTransformerTest extends AdminBundleTestCase
{
    private $transformer;

    protected function setUp()
    {
        $this->transformer = new NewTagsTransformer();
    }

    public function testTransform()
    {
        $tagCollection = new ArrayCollection(
            array(
                new Tag('tag-0'),
                new Tag('tag-1'),
                new Tag('tag-2'),
            )
        );

        $result = $this->transformer->transform($tagCollection);

        $this->assertEquals(
            'tag-0,tag-1,tag-2',
            $result
        );
    }

    public function testTransformWithNull()
    {
        $result = $this->transformer->transform();

        $this->assertEquals(
            $result,
            ''
        );
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testTransformWithNonObjectThrowsException()
    {
        $this->transformer->transform('non-object');
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testTransformWithNonArrayCollectionThrowsException()
    {
        $this->transformer->transform(new \stdClass());
    }

    public function testReverseTransform()
    {
        $value = 'tag-0,tag-1';

        $result = $this->transformer->reverseTransform($value);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $result
        );

        $this->assertTrue($result->count() === 2);

        $tags = $result->toArray();
        $this->assertEquals(
            $tags[0]->getName(),
            'tag-0'
        );
        $this->assertEquals(
            $tags[1]->getName(),
            'tag-1'
        );
    }

    public function testReverseTransformWithNull()
    {
        $result = $this->transformer->reverseTransform();

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $result
        );

        $this->assertTrue($result->count() === 0);
    }

    /**
     * @expectedException Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testReverseTransformWithNonStringThrowsException()
    {
        $result = $this->transformer->reverseTransform(3);
    }
}
