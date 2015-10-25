<?php

namespace RCatlin\Blog\Test\Unit\ReverseTransformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use RCatlin\Blog\Test\Unit\HasFaker;

class ArticleReverseTransformerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testReverseTransformExistingArticle()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber();
        $slug = $faker->word;
        $title = $faker->sentence;
        $content = $faker->sentence;
        $active = $faker->boolean();

        $values = [
            'id' => $id,
            'slug' => $slug,
            'title' => $title,
            'content' => $content,
            'active' => $active,
            'tags' => ['tag-values'],
        ];

        $article = $this->getMockArticle();
        $tag0 = $this->getMockTag();
        $tag1 = $this->getMockTag();

        $repository = $this->getMockArticleRepository();
        $repository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($article)
        ;

        $article->expects($this->once())
            ->method('setSlug')
            ->with($slug)
        ;

        $article->expects($this->once())
            ->method('setTitle')
            ->with($title)
        ;

        $article->expects($this->once())
            ->method('setContent')
            ->with($content)
        ;

        $article->expects($this->once())
            ->method('setTags')
            ->with([$tag0, $tag1])
        ;

        $article->expects($this->once())
            ->method('setActive')
            ->with($active)
        ;

        $tagReverseTransformer = $this->getMockTagReverseTransformer();
        $tagReverseTransformer->expects($this->once())
            ->method('reverseTransformAll')
            ->with(['tag-values'])
            ->willReturn([$tag0, $tag1])
        ;

        $reverseTransformer = new ReverseTransformer\Entity\ArticleReverseTransformer(
            $repository,
            $tagReverseTransformer
        );

        $result = $reverseTransformer->reverseTransform($values);

        $this->assertInstanceOf(Entity\Article::class, $result);
    }

    public function testReverseTransformNewArticle()
    {
        $faker = $this->getFaker();

        $values = [
            'slug' => $faker->word,
            'title' => $faker->sentence,
            'content' => $faker->sentence,
            'active' => $faker->boolean(),
            'tags' => ['tag-values'],
        ];

        $tag = $this->getMockTag();

        $tagReverseTransformer = $this->getMockTagReverseTransformer();
        $tagReverseTransformer->expects($this->once())
            ->method('reverseTransformAll')
            ->with(['tag-values'])
            ->willReturn([$tag])
        ;

        $reverseTransformer = new ReverseTransformer\Entity\ArticleReverseTransformer(
            $this->getMockArticleRepository(),
            $tagReverseTransformer
        );

        $result = $reverseTransformer->reverseTransform($values);

        $this->assertInstanceOf(Entity\Article::class, $result);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\ArticleRepository
     */
    private function getMockArticleRepository()
    {
        return $this->buildMock(Repository\ArticleRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ReverseTransformer\Entity\TagReverseTransformer
     */
    private function getMockTagReverseTransformer()
    {
        return $this->buildMock(ReverseTransformer\Entity\TagReverseTransformer::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Article
     */
    private function getMockArticle()
    {
        return $this->buildMock(Entity\Article::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    private function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
    }
}
