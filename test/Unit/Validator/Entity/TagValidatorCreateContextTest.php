<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\TagValidator;

class TagValidatorCreateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator();
        $validationResult = $validator->validate($this->getAllValues(), Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    public function testRequiresTag()
    {
        $validator = new TagValidator();

        $validationResult = $validator->validate([], Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    public function testNameCannotBeEmpty()
    {
        $validator = new TagValidator();

        $validationResult = $validator->validate(['name' => ''], Context::CREATE);

        $this->assertFalse($validationResult->isValid());
    }

    private function getAllValues()
    {
        return [
            'name' => $this->getFaker()->word,
        ];
    }
}
