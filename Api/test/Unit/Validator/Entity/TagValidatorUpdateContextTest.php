<?php

namespace RCatlin\Api\Test\Unit\Validator\Entity;

use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Validator\Context;
use RCatlin\Api\Validator\Entity\TagValidator;

class TagValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new TagValidator();

        $validationResult = $validator->validate($this->getAllValues(), Context::UPDATE);

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
