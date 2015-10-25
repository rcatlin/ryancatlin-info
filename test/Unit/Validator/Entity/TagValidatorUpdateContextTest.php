<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\TagValidator;

class TagValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator();

        $validationResult = $validator->validate($this->getAllValues(), Context::UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresId()
    {
        $values = $this->getAllValues();
        unset($values['id']);

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testIdCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['id'] = null;

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testIdMustBeAnInteger()
    {
        $values = $this->getAllValues();
        $values['id'] = $this->getFaker()->word;

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testRequiresName()
    {
        $values = $this->getAllValues();
        unset($values['name']);

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testNameCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['name'] = '';

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testNameMustBeAString()
    {
        $values = $this->getAllValues();
        $values['id'] = $this->getFaker()->word;

        $validator = new TagValidator();

        $validationResult = $validator->validate($values, Context::UPDATE);

        $this->assertFalse($validationResult->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
            'id' => $faker->randomNumber(),
            'name' => $faker->word,
        ];
    }
}
