<?php

namespace RCatlin\Blog\Tests\Validator\Entity;

use RCatlin\Blog\Tests\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\ArticleValidator;

class ArticleValidatorCreateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator(
            Context::CREATE,
            $this->getAllValues()
        );

        $this->assertTrue($validator->isValid());
    }

    public function testRequiresSlug()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiresNonEmptySlug()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiresTitle()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiresNonEmptyTitle()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiresContent()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiredContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testRequiresTags()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiredTagsCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testRequiredTagsMustBeArray()
    {
        $values = $this->getAllValues();
        $values['tags'] = $this->getFaker()->word;

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testActiveIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    public function testOptionalActiveCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['active'] = null;

        $validator = new ArticleValidator(
            Context::CREATE,
            $values
        );

        $this->assertTrue($validator->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
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
