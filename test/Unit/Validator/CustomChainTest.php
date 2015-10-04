<?php

namespace RCatlin\Blog\Test\Unit\Validator;

use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Validator\CustomChain;
use RCatlin\Blog\Validator\Rule;

class CustomChainTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testHasIsArrayRule()
    {
        $faker = $this->getFaker();

        $chain = new CustomChain(
            $faker->word,
            $faker->word,
            $faker->boolean(),
            $faker->boolean()
        );

        $result = $chain->isArray();

        $reflection = new \ReflectionObject($result);
        $property = $reflection->getProperty('rules');
        $property->setAccessible(true);
        $rules = $property->getValue($result);


        $hasRule = false;
        foreach ($rules as $rule) {
            if (!$this->isInstanceOf(Rule\IsArrayRule::class, $rule)) {
                continue;
            }
            $hasRule = true;
            break;
        }

        $this->assertTrue($hasRule);
    }
}
