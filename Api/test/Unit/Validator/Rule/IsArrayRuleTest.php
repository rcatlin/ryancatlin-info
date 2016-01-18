<?php

namespace RCatlin\Blog\Test\Unit\Validator\Rule;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Validator\Rule;

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
