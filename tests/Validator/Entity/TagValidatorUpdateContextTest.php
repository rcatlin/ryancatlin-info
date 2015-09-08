<?php

namespace RCatlin\Blog\Tests\Validator\Entity;

use RCatlin\Blog\Tests\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\TagValidator;

class TagValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator(
            Context::UPDATE,
            $this->getAllValues()
        );

        $this->assertTrue($validator->isValid());
    }

    public function testRequiresId()
    {
        $values = $this->getAllValues();
        unset($values['id']);

        $validator = new TagValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testIdCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['id'] = null;

        $validator = new TagValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testIdMustBeAnInteger()
    {
        $values = $this->getAllValues();
        $values['id'] = $this->getFaker()->word;

        $validator = new TagValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testRequiresName()
    {
        $values = $this->getAllValues();
        unset($values['name']);

        $validator = new TagValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testNameCannotBeEmpty()
    {
        $values = $this->getAllValues();
        $values['name'] = '';

        $validator = new TagValidator(
            Context::UPDATE,
            $values
        );

        $this->assertFalse($validator->isValid());
    }

    public function testNameMustBeAString()
    {
        $values = $this->getAllValues();
        $values['id'] = $this->getFaker()->word;

        $validator = new TagValidator(
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
            'name' => $faker->word,
        ];
    }
}
