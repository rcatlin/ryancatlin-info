<?php

namespace RCatlin\Blog\test\Unit\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Test\Unit\HasFaker;

class TagTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testFromValues()
    {
        $name = $this->getFaker()->word;

        $tag = Entity\Tag::fromValues($name);

        $this->assertSame($name, $tag->getName());
    }

    public function testSetAndGetName()
    {
        $tag = $this->createTag();

        $word = $this->getFaker()->word;

        $tag->setName($word);

        $this->assertSame($word, $tag->getName());
    }

    /**
     * @return Entity\Tag
     */
    private function createTag()
    {
        $name = $this->getFaker()->name;

        return Entity\Tag::fromValues($name);
    }
}
