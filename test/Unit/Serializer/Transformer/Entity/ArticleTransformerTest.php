<?php

namespace RCatlin\Blog\Test\Unit\Serializer\Transformer\Entity;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer\Transformer;
use RCatlin\Blog\Test\Unit\HasFaker;

class ArticleTransformerTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testTransform()
    {
        $faker = $this->getFaker();

        $slug = $faker->word;
        $title = $faker->sentence();
        $content = $faker->paragraph();
        $active = $faker->boolean();

        // Create and setup the first Tag
        $firstTagName = $faker->word;
        $firstTag = Entity\Tag::fromValues($firstTagName);

        // Create and setup the second Tag
        $secondTagName = $faker->word;
        $secondTag = Entity\Tag::fromValues($secondTagName);

        // Add Tags to Article
        $article = Entity\Article::fromValues($slug, $title, $content, [$firstTag, $secondTag], $active);

        $transformer = new Transformer\Entity\ArticleTransformer(
            new Transformer\Entity\TagTransformer(),
            new Transformer\DateTimeTransformer()
        );

        $this->assertSame(
            [
                'id' => null,
                'slug' => $slug,
                'title' => $title,
                'created_at' => null,
                'updated_at' => null,
                'content' => $content,
                'tags' => [
                    [
                        'id' => null,
                        'name' => $firstTagName,
                    ],
                    [
                        'id' => null,
                        'name' => $secondTagName,
                    ],
                ],
                'active' => $active,
            ],
            $transformer->transform($article)
        );
    }
}
