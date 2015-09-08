<?php

namespace MyProject\Tests\Bundle\MainBundle\Entity;

use MyProject\Tests\Bundle\MainBundle\MainBundleTestCase;
use MyProject\Bundle\MainBundle\Entity\Tag;

class TagTest extends MainBundleTestCase
{
    public function testSettersAndGetters()
    {
        $name = 'tag name';

        // Create test object
        $tag = new Tag();

        $tag->setName($name);

        // Assertions
        $this->assertNull($tag->getId());

        $this->assertEquals(
            $name,
            $tag->getName()
        );

        $this->assertEquals(
            $name,
            (string) $tag
        );
    }
}
