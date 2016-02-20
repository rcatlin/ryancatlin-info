<?php

namespace RCatlin\Api\Test\Unit\Validator\Rule;

use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Validator\Rule;

class IsArrayRuleTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testValidateIsTrue()
    {
        $rule = new Rule\IsArrayRule();

        $this->assertTrue($rule->validate([]));
    }

    public function testValidateIsFalse()
    {
        $faker = $this->getFaker();

        $rule = new Rule\IsArrayRule();

        $this->assertFalse($rule->validate($faker->word));
    }
}
