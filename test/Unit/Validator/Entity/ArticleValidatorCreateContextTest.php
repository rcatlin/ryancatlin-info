<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\ArticleValidator;

class ArticleValidatorCreateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator();

        $validationResult = $validator->validate($this->getAllValues(), Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresSlug()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresNonEmptySlug()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresTitle()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresNonEmptyTitle()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresContent()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiredContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresTags()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiredTagsCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiredTagsMustBeArray()
    {
        $values = $this->getAllValues();
        $values['tags'] = $this->getFaker()->word;

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testActiveIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testOptionalActiveCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['active'] = null;

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
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
