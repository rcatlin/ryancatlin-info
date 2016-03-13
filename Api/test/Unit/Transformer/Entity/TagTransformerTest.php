<?php

namespace RCatlin\Api\Test\Unit\Transformer\Entity;

use RCatlin\Api\Entity;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Transformer\Entity\TagTransformer;

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
