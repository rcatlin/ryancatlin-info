<?php

namespace RCatlin\Blog\Test\Unit\ReverseTransformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Test\Unit\HasFaker;

class TagReverseTransformerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testReverseTransformNewTag()
    {
        $name = $this->getFaker()->word;

        $reverseTransformer = new ReverseTransformer\Entity\TagReverseTransformer($this->getMockTagRepository());

        $tag = $reverseTransformer->reverseTransform(['name' => $name]);

        $this->assertInstanceOf(Entity\Tag::class, $tag);
        $this->assertEquals($name, $tag->getName());
    }

    public function testReverseTransformerExistingTag()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber();
        $newName = $faker->word;

        $values = [
            'id' => $id,
            'name' => $newName,
        ];

        $tag = $this->getMockTag();

        $repository = $this->getMockTagRepository();
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($tag)
        ;

        $tag->expects($this->once())
            ->method('setName')
            ->with($newName)
        ;

        $reverseTransformer = new ReverseTransformer\Entity\TagReverseTransformer($repository);

        $result = $reverseTransformer->reverseTransform($values);

        $this->assertSame($tag, $result);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\TagRepository
     */
    private function getMockTagRepository()
    {
        return $this->buildMock(Repository\TagRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    private function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
    }
}
