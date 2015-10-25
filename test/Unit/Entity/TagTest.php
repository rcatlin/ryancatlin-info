<?php

namespace RCatlin\Blog\Test\Unit\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Unit\BuildsMocks;

class TagTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testFromValues()
    {
        $name = $this->getFaker()->word;

        $tag = Entity\Tag::fromValues($name);

        $this->assertInstanceOf(Entity\Tag::class, $tag);
        $this->assertSame($name, $tag->getName());
    }

    public function testFromArray()
    {
        $name = $this->getFaker()->word;

        $tag = Entity\Tag::fromArray(['name' => $name]);

        $this->assertInstanceOf(Entity\Tag::class, $tag);
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
