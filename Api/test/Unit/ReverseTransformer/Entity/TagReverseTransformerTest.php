<?php

namespace RCatlin\Api\Test\Unit\ReverseTransformer\Entity;

use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\Unit\BuildsMocks;

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
