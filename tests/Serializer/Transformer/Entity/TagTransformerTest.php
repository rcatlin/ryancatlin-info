<?php

namespace RCatlin\Blog\Tests\Serializer\Transformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer\Transformer\Entity\TagTransformer;
use RCatlin\Blog\Tests\HasFaker;

class TagTransformerTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testTransform()
    {
        $id = $this->getFaker()->randomNumber();
        $name = $this->getFaker()->word;

        $tag = new Entity\Tag($name);
        
        $reflection = new \ReflectionObject($tag);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($tag, $id);

        $transformer = new TagTransformer();

        $this->assertSame(
            [
                'id' => $id,
                'name' => $name,
            ],
            $transformer->transform($tag)
        );
    }
}
