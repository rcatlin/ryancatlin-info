<?php

namespace RCatlin\Blog\Tests\Validator\Entity;

use RCatlin\Blog\Tests\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\ArticleValidator;

class ArticleValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator(
            Context::UPDATE,
            $this->getAllValues()
        );

        $this->assertTrue($validator->isValid());
    }

    public function testSlugIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testSlugCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testTitleIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testTitleCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testContentIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testTagsIsOptiona()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testTagsCanBeEmptry()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testActiveIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testActiveCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['slug'] = null;

        $validator = new ArticleValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
            'id' => $faker->randomNumber(),
            'slug' => $faker->word,
            'title' => $faker->sentence(),
            'content' => $faker->paragraph,
            'tags' => [
                $faker->word,
                $faker->word,
            ],
            'active' => $faker->boolean(),
        ];
    }
}
