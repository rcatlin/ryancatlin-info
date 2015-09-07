<?php

namespace RCatlin\Blog\Validator;

use Particle\Validator\Chain;
use RCatlin\Blog\Validator\Rule;

class CustomChain extends Chain
{
    public function isArray()
    {
        return $this->addRule(new Rule\IsArrayRule());
    }
}
