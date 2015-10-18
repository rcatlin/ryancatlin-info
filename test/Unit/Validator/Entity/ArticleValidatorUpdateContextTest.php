<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\ArticleValidator;

class ArticleValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator();

        $validationResult = $validator->validate($this->getAllValues(), Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testSlugIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testSlugCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testTitleIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTitleCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testContentIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTagsIsOptiona()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTagsCanBeEmptry()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testActiveIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testActiveCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['slug'] = null;

        $validator = new ArticleValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
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
