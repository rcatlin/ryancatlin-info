<?php

namespace RCatlin\Api\Test\Unit\Validator\Entity;

use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Validator\Context;
use RCatlin\Api\Validator\Entity\ArticleValidator;
use RCatlin\Api\Validator\Entity\TagValidator;

class ArticleValidatorPartialUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($this->getAllValues(), Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testSlugIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testSlugCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testTitleIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTitleCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testContentIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTagsIsOptiona()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testTagsCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testActiveIsOptional()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testActiveCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['active'] = null;

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::PARTIAL_UPDATE);

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
                [$faker->word],
                [$faker->word],
            ],
            'active' => $faker->boolean(),
        ];
    }
}
