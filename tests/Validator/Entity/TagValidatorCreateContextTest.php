<?php

namespace RCatlin\Blog\Tests\Validator\Entity;

use RCatlin\Blog\Tests\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\TagValidator;

class TagValidatorCreateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator(
            Context::CREATE,
            $this->getAllValues()
        );

        $this->assertTrue($validator->isValid());
    }

    public function testRequiresTag()
    {
        $validator = new TagValidator(
            Context::CREATE,
            []
        );

        $this->assertFalse($validator->isValid());
    }

    public function testNameCannotBeEmpty()
    {
        $validator = new TagValidator(
            Context::CREATE,
            ['name' => '']
        );

        $this->assertFalse($validator->isValid());
    }

    private function getAllValues()
    {
        return [
            'name' => $this->getFaker()->word,
        ];
    }
}
