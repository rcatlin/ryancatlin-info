<?php

namespace RCatlin\Blog\Tests\Serializer\Transformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer\Transformer\DateTimeTransformer;
use RCatlin\Blog\Serializer\Transformer\Entity\ArticleTransformer;
use RCatlin\Blog\Tests\HasFaker;

class ArticleTransformerTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testTransform()
    {
        $faker = $this->getFaker();

        $id = $faker->randomNumber();
        $slug = $faker->word;
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $active = $faker->boolean();

        $now = new \DateTime();

        // Create and setup the first Tag
        $firstTagName = $faker->word;
        $firstTagId = $faker->randomNumber();
        $firstTag = new Entity\Tag($firstTagName);
        $reflection = new \ReflectionObject($firstTag);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($firstTag, $firstTagId);

        // Create and setup the second Tag
        $secondTagName = $faker->word;
        $secondTagId = $faker->randomNumber();
        $secondTag = new Entity\Tag($secondTagName);
        $reflection = new \ReflectionObject($firstTag);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($secondTag, $secondTagId);

        // Create and setup the Article
        $article = new ArticleStub($now);
        $reflection = new \ReflectionObject($article);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($article, $id);

        // Add Tags to Article
        $article->setSlug($slug);
        $article->setTitle($title);
        $article->setContent($content);
        $article->addTags([$firstTag, $secondTag]);
        $article->setActive($active);

        $transformer = new ArticleTransformer();

        $this->assertSame(
            [
                'id' => $id,
                'slug' => $slug,
                'title' => $title,
                'created_at' => $now->format(DateTimeTransformer::FORMAT),
                'updated_at' => $now->format(DateTimeTransformer::FORMAT),
                'content' => $content,
                'tags' => [
                    $firstTagId => [
                        'id' => $firstTagId,
                        'name' => $firstTagName,
                    ],
                    $secondTagId => [
                        'id' => $secondTagId,
                        'name' => $secondTagName,
                    ],
                ],
                'active' => $active,
            ],
            $transformer->transformer($article)
        );
    }
}
