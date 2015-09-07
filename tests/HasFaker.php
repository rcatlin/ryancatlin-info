<?php

namespace RCatlin\Blog\Tests;

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
