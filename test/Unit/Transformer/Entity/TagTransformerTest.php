<?php

namespace RCatlin\Blog\Test\Unit\Transformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Transformer\Entity\TagTransformer;

class TagTransformerTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testTransform()
    {
        $name = $this->getFaker()->word;

        $tag = Entity\Tag::fromValues($name);

        $transformer = new TagTransformer();

        $this->assertSame(
            [
                'id' => null,
                'name' => $name,
            ],
            $transformer->transform($tag)
        );
    }
}
