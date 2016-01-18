<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\TagValidator;

class TagValidatorPartialUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator();

        $validationResult = $validator->validate($this->getAllValues(), Context::PARTIAL_UPDATE);

        $this->assertTrue($validationResult->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
            'name' => $faker->word,
        ];
    }
}
