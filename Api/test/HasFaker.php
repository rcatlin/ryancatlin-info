<?php

namespace RCatlin\Api\Test;

use Faker\Factory;

trait HasFaker
{
    /**
     * @return \Faker\Generator
     */
    protected function getFaker()
    {
        return Factory::create();
    }
}
