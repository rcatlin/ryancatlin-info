<?php

namespace RCatlin\Api\Test\Unit\Validator\Entity;

use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Validator\Context;
use RCatlin\Api\Validator\Entity\ArticleValidator;
use RCatlin\Api\Validator\Entity\TagValidator;

class ArticleValidatorCreateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($this->getAllValues(), Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresSlug()
    {
        $values = $this->getAllValues();
        unset($values['slug']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresNonEmptySlug()
    {
        $values = $this->getAllValues();
        $values['slug'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testSlugCanContainHyphensAndUnderlines()
    {
        $values = $this->getAllValues();
        $values['slug'] = 'this-is_a-test';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testSlugCannotEndWithHyphen()
    {
        $values = $this->getAllValues();
        $values['slug'] = 'bad-slug-';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testSlugCannotEndWithAnUnderline()
    {
        $values = $this->getAllValues();
        $values['slug'] = 'bad_slug_';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresTitle()
    {
        $values = $this->getAllValues();
        unset($values['title']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresNonEmptyTitle()
    {
        $values = $this->getAllValues();
        $values['title'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresContent()
    {
        $values = $this->getAllValues();
        unset($values['content']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiredContentCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['content'] = '';

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresTags()
    {
        $values = $this->getAllValues();
        unset($values['tags']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiredTagsCanBeEmpty()
    {
        $values = $this->getAllValues();
        $values['tags'] = [];

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiredTagsMustBeArray()
    {
        $values = $this->getAllValues();
        $values['tags'] = $this->getFaker()->word;

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testActiveIsRequired()
    {
        $values = $this->getAllValues();
        unset($values['active']);

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testOptionalActiveCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['active'] = null;

        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($values, Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
            'slug' => $faker->word,
            'title' => $faker->sentence(),
            'content' => $faker->paragraph,
            'tags' => [
                ['name' => $faker->word],
                ['name' => $faker->word],
            ],
            'active' => $faker->boolean(),
        ];
    }
}
