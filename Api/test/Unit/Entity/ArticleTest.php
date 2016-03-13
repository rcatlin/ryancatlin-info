<?php

namespace RCatlin\Api\Test\Unit\Entity;

use RCatlin\Api\Entity;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\Unit\BuildsMocks;

class ArticleTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testFromValues()
    {
        $faker = $this->getFaker();

        $tag = $this->getMockTag();

        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->paragraph;
        $tags = [$tag];
        $active = $faker->boolean();

        $article = Entity\Article::fromValues($slug, $title, $content, $tags, $active);

        $this->assertSame($slug, $article->getSlug());
        $this->assertSame($title, $article->getTitle());
        $this->assertSame($content, $article->getContent());
        $this->assertSame(1, $article->getTags()->count());
        $this->assertSame($tag, $article->getTags()->first());
        $this->assertSame($active, $article->getActive());
    }

    public function testFromArray()
    {
        $faker = $this->getFaker();

        $tag = $this->getMockTag();

        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->paragraph;
        $tags = [$tag];
        $active = $faker->boolean();

        $values = [
            'slug' => $slug,
            'title' => $title,
            'content' => $content,
            'tags' => $tags,
            'active' => $active,
        ];

        $article = Entity\Article::fromArray($values);

        $this->assertSame($slug, $article->getSlug());
        $this->assertSame($title, $article->getTitle());
        $this->assertSame($content, $article->getContent());
        $this->assertSame(1, $article->getTags()->count());
        $this->assertSame($tag, $article->getTags()->first());
        $this->assertSame($active, $article->getActive());
    }

    public function testSetAndGetSlug()
    {
        $article = $this->createArticle();

        $slug = $this->getFaker()->word;
        $article->setSlug($slug);

        $this->assertSame($slug, $article->getSlug());
    }

    public function testSetAndGetTitle()
    {
        $article = $this->createArticle();

        $title = $this->getFaker()->sentence;
        $article->setTitle($title);

        $this->assertSame($title, $article->getTitle());
    }

    public function testSetAndGetContent()
    {
        $article = $this->createArticle();

        $content = $this->getFaker()->paragraph;
        $article->setContent($content);

        $this->assertSame($content, $article->getContent());
    }

    public function testAddAndGetTag()
    {
        $article = $this->createArticle();

        $tag = $this->getMockTag();
        $article->addTag($tag);

        $this->assertSame($tag, $article->getTags()->first());
    }

    public function testSetAndGetTags()
    {
        $article = $this->createArticle();

        $tag0 = $this->getMockTag();
        $tag1 = $this->getMockTag();
        $tags = [$tag0, $tag1];

        $article->setTags($tags);

        $articleTags = $article->getTags();

        $this->assertTrue($articleTags->contains($tag0));
        $this->assertTrue($articleTags->contains($tag1));
    }

    public function testSetAndGetActive()
    {
        $article = $this->createArticle();

        $active = $this->getFaker()->boolean();

        $article->setActive($active);

        $this->assertSame($active, $article->getActive());
    }

    /**
     * @return Entity\Article
     */
    private function createArticle()
    {
        $faker = $this->getFaker();

        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->paragraph;
        $tags = [];
        $active = $faker->boolean();

        return Entity\Article::fromValues($slug, $title, $content, $tags, $active);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    private function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
    }
}
